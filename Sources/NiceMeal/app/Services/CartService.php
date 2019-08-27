<?php
namespace App\Services;
use App\Models\Restaurant;
use App\Models\Promotion;
use App\Models\PromotionAvailableTime;
use App\Models\PromotionAffect;
use App\Models\PromotionUsage;
use App\Models\Dish;
use App\Models\Tax;
use App\Models\RestaurantDeliverySetting;
use App\Services\TBDService;
use App\Services\TBPService;
use Carbon\Carbon;
use App\Models\TimeBaseDisplayRule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Session, Log;


class CartService {


    public static function doAdd($cart, $item){
        $duplicate = false;
        $cart_items = $cart['items'];
        $item['options'] = collect($item['options'])->filter(static function($value,$key){
            return $value !== null;
        })->toArray();
        if(count($cart_items) > 0){
            foreach($cart_items as &$i){
                if($item['id'] == $i['id']){
                    $input_temp_options = array_column($item['options'],'quantity','option_id');
                    $temp_options = array_column($i['options'],'quantity','option_id');
                    if(count(array_diff_assoc($input_temp_options,$temp_options)) == 0 ){
                        $duplicate = true;
                        $i['quantity'] += $item['quantity'];
                    }
                }
            }
        }
        if(!$duplicate){
            array_push($cart_items,$item);
        }
        $cart['items'] = $cart_items;
        $cart = self::updateCartInfo($cart);
        return $cart;
    }

    public static function calDishPrice($cartItem, $includeRequest=true, $optionNegative = true) {
        $dishPrice = $cartItem['price'];

        if ($includeRequest == true) $dishPrice += self::calDishCustomsPrice($cartItem,$optionNegative);

        return $dishPrice;
    }

    public static function calDishCustomsPrice($cartItem, $optionNegative = true) {
        $customPrice = 0;
        $options = collect($cartItem['options']);
        //if none negative, remove negative price
        if(!$optionNegative){
          $options = $options->filter(function($option){
            return $option['price'] > 0;
          });
        }
        foreach($options as $custom){
            $customPrice+= $custom['price'] * $custom['quantity'];
        }
        return $customPrice;
    }

    public static function calculateOriginalSubTotal($cart, $includeRequest=true,$optionNegative = true){
        $sub_total = 0;
        foreach($cart['items'] as $cartItem){
            $dish_price = self::calDishPrice($cartItem, $includeRequest, $optionNegative);
            $sub_total += $dish_price * $cartItem['quantity'];
        }
        return $sub_total;
    }

    public static function calculateSubTotal($cart, $includeRequest=true){
        $sub_total = self::calculateOriginalSubTotal($cart);
        return max(0, self::getValueBeforeTax($cart['restaurant_id'], $sub_total));
    }

    public static function updateCartInfo($cart){
        $cart['sub_total'] = self::calculateSubTotal($cart);
        $cart['tax_type'] = self::getTaxType($cart) ?? NULL;
        $cart['tax'] = self::getTax($cart) ?? 0;
        $promotionCart = self::calPromotion($cart);
        $cart['promotion'] = $promotionCart['value'];
        $cart['promotions'] = $promotionCart['promotions'];
        $cart['tax_bill'] = self::calTax($cart);
        $cart['delivery_fee'] = self::calculateDeliveryFee($cart);
        $cart['order_total'] = self::calculateTotal($cart);
        $cart['total_item'] = self::countTotalItem($cart);
        return $cart;
    }

    public static function countTotalItem($cart){
        $total = 0;
        foreach($cart['items'] as $item){
            $total += $item['quantity'];
        }
        return $total;
    }

    public static function calculateTotal($cart){
        $total = $cart['sub_total'] - $cart['promotion'] + $cart['tax_bill'];
        return max(self::roundCurrency($total, 3), 0) + $cart['delivery_fee'];
    }

    public static function calculateDeliveryFee($cart) {
      if($cart['service'] == "delivery"){
        $deliverySetting = RestaurantDeliverySetting::where('district_id','=',$cart['location_info']['district_id'])->where('restaurant_id','=',$cart['restaurant_id']);
        $deliveryFee = 0;
        if($cart['location_info']['ward_id'] == null){
          $deliverySetting = $deliverySetting->where(function($query){
            $query = $query->whereNull('ward_id');
          });
        }else{
          $deliverySetting = $deliverySetting->where(function($query) use ($cart){
            $query = $query->whereNull('ward_id')->orWhere('ward_id','=',$cart['location_info']['ward_id']);
          });
        }
        $deliverySetting = $deliverySetting->get();
        $availSetting = $deliverySetting->where('from','<=',$cart['sub_total'])->where('to','>=',$cart['sub_total']);
        if($availSetting->count() == 0){
          $parentSetting = $deliverySetting->where('parent_id','=',0)->where('min_order_amount','>=',$cart['sub_total']);
          if($parentSetting->count() > 0){
            $deliveryFee = $parentSetting->first()->delivery_cost;
          }
        }else{
          $deliveryFee = $availSetting->first()->delivery_cost;
        }

        return $deliveryFee;
      }else{
        return 0;
      }
    }

    public static function calcMaxTotalBillTo($resDeliSettings) {
        $max=0;
        foreach($resDeliSettings as $resDeliSetting){
            if($max < $resDeliSetting['to']){
                $max = $resDeliSetting['to'];
            }
        }
        return $max;
    }

    public static function calcDeliFeeDefault($cart, $resDeliSettings) {
        foreach ($resDeliSettings as $resDeliSetting) {
            if($resDeliSetting['parent_id'] == 0){
                $cart['delivery_fee'] = $resDeliSetting['delivery_cost'];
            }
        }
        return $cart['delivery_fee'];
    }

    public static function initCart($extra_field = []){
        $cart = [];
        $cart['items'] = [];
        $cart['sub_total'] = 0;
        $cart['payment'] = "";
        $cart['promotion'] = 0;
        $cart['voucher'] = NULL;
        $cart['order_note'] = "";
        $cart['restaurant'] = (isset($extra_field['restaurant'])) ? $extra_field['restaurant'] : "";
        $cart['restaurant_id'] = (isset($extra_field['restaurant_id'])) ? $extra_field['restaurant_id'] : 0;
        $cart['service'] = "";
        $cart['delivery_fee'] = 0;
        $cart['order_total'] = 0;
        $cart['total_item']  = 0;
        $cart['tax'] =0;
        $cart['tax_type'] = -1;
        $cart['tax_bill'] = 0;
        $cart['checkbill'] = 0;
        $cart['promotions'] = [];
        $cart['min_order_amount'] = (isset($extra_field['min_order_amount'])) ? $extra_field['min_order_amount'] : 0;
        $cart['payment_with'] = '';
        $cart['location_info'] = [
          "district_id" => (isset($extra_field['district_id'])) ? $extra_field['district_id'] : 0,
          "ward_id" => (isset($extra_field['ward_id'])) ? $extra_field['ward_id'] : 0
        ];
        return $cart;
    }

    public static function getValidPromotions($cart) {
        $promotions = Promotion::where('is_global', 0)
            ->where('restaurant_id', $cart['restaurant_id'])
            ->where('status', 1)
            ->get();
        $promotions->filter(function($promo) {
            return $promo->isAvailable() == true;
        });
        $promotions->load('promotion_affects');
        return $promotions;
    }

    public static function calPromotion($cart) {
        if(count($cart['items']) == 0){
          return [
            'value' => 0,
            'promotions' => []
          ];
        }
        $result = 0;

        if (isset($cart['is_restaurant_page']) && $cart['is_restaurant_page'] == true) {
            $cart = self::removeAllFreeItems($cart);
            unset($cart['is_restaurant_page']);
        }
        //check promotion of restaurant
        $promotions = self::getValidPromotions($cart);
        $cartPromotions = collect();

        foreach($promotions as $promotion) {

            $discount = 0;
            switch($promotion->apply_to) {
                case Promotion::PROMOTION_APPLY_TO['BY MENU']:
                    foreach($cart['items'] as $item) {
                        $itemPrice = self::calDishPrice($item, $promotion->include_request,false);
                        if ($promotion->item_value_from <= $itemPrice && $itemPrice <= $promotion->item_value_to) {

                            if ($promotion->type == Promotion::PROMOTION_TYPES['free_item']) {
                                $cart = self::addFreeItems($cart, $promotion, $item['quantity']);
                            }
                            else {
                                $discount += self::calDiscountItem($cart['restaurant_id'], $item, $promotion);
                            }

                            if (!self::isCartHadPromotion($cartPromotions, $promotion)) $cartPromotions->push($promotion);
                        }
                    }
                    break;
                case Promotion::PROMOTION_APPLY_TO['BY CATEGORY']:
                    $categories_id = $promotion->promotion_affects->pluck('category_id');
                    if(count($categories_id) > 0) {
                        foreach($categories_id as $category_id) {
                            foreach($cart['items'] as $item) {
                                $itemPrice = self::calDishPrice($item, $promotion->include_request,false);
                                if ($item['category_id'] == $category_id && $promotion->item_value_from <= $itemPrice && $itemPrice <= $promotion->item_value_to) {
                                    if ($promotion->type == Promotion::PROMOTION_TYPES['free_item']) {
                                        $cart = self::addFreeItems($cart, $promotion, $item['quantity']);
                                    }
                                    else {
                                        $discount += self::calDiscountItem($cart['restaurant_id'], $item, $promotion);
                                    }

                                    if (!self::isCartHadPromotion($cartPromotions, $promotion)) $cartPromotions->push($promotion);
                                }
                            }
                        }
                    }
                    break;
                case Promotion::PROMOTION_APPLY_TO['BY ITEM']:
                    $dishes_id = $promotion->promotion_affects->pluck('dish_id');
                    if(count($dishes_id) > 0) {
                        foreach($dishes_id as $dish_id) {
                            foreach($cart['items'] as $item) {
                                if ($item['id'] == $dish_id) {

                                    if ($promotion->type == Promotion::PROMOTION_TYPES['free_item']) {
                                        $cart = self::addFreeItems($cart, $promotion, $item['quantity']);
                                    }
                                    else {
                                        $discount += self::calDiscountItem($cart['restaurant_id'], $item, $promotion);
                                    }

                                    if (!self::isCartHadPromotion($cartPromotions, $promotion)) $cartPromotions->push($promotion);
                                }
                            }
                        }
                    }
                    break;
                case Promotion::PROMOTION_APPLY_TO['BY BILL']:
                      $subTotal = self::calculateOriginalSubTotal($cart,true,false);
                      if($promotion->min_order_value <= $subTotal && $subTotal <= $promotion->max_order_value) {
                        $subTotal = self::getValueBeforeTax($cart['restaurant_id'],$subTotal);
                        if ($promotion->type == Promotion::PROMOTION_TYPES['free_item']) {
                            $cart = self::addFreeItems($cart, $promotion, 1);
                        }
                        else {
                            if ($promotion->type == Promotion::PROMOTION_TYPES['%']) {
                                $discount = $subTotal*$promotion->value/100;
                                $discount = min($discount, $promotion->maximun_discount);
                            }
                            else if ($promotion->type == Promotion::PROMOTION_TYPES['value']) {
                                $discount = $promotion->value;
                            }
                        }

                        if (!self::isCartHadPromotion($cartPromotions, $promotion)) $cartPromotions->push($promotion);
                    }
                    break;
            }
            $result += $discount;
        }
        $restaurant = Restaurant::where('slug', $cart['restaurant'])->first();
        //check voucher of admin
        $voucher = Promotion::where('is_global', 1)->where('id', $cart['voucher']['id'])->where('status',1)->first();
        $result += self::calVoucher($cart, $voucher);
        $result = ($restaurant->maximum_discount) ? min($result, $restaurant->maximum_discount) : $result;
        return [
            'value' => self::roundCurrency($result, 3),
            'promotions' => $cartPromotions
        ];
    }

    public static function isCartPromotionsChange($cart) {
        $newCartPromotion = self::calPromotion($cart);
        if ($newCartPromotion['value'] != $cart['promotion'] ||
            count($newCartPromotion['promotions']) != count($cart['promotions'])) return true;
        else {
            foreach($newCartPromotion['promotions'] as $idx=>$promotion) {
                $cartPromotion = $cart['promotions'][$idx];
                if($promotion->id != $cartPromotion['id'] || $promotion->free_item != $cartPromotion['free_item']) return true;
            }
        }

        return false;
    }

    public static function isCartHadPromotion($cartPromotions, $promotion) {
        return collect($cartPromotions)->where('id', $promotion->id)->isNotEmpty();
    }

    public static function calTax($cart) {
        if ($cart['tax_type'] == Tax::TYPES['exclusive'] && $cart['checkbill'] == 0 )
            return 0;
        else
            return max(0, round(($cart['sub_total']-$cart['promotion'])*$cart['tax']/100, 3));
    }

    public static function getValueBeforeTax($restaurant_id,$value) {
        $tax = Tax::where('restaurant_id', $restaurant_id)->first();
        return ($tax && $tax->type == Tax::TYPES['inclusive']) ? $value/((100+$tax->rate)/100) : $value;
    }

    public static function getValueAfterTax($restaurant_id,$value) {
        $tax = Tax::where('restaurant_id', $restaurant_id)->first();
        if (!$tax) return $value;
        return $value*(1+$tax->rate/100);
    }

    public static function addFreeItems($cart, $promotion, $quantity = 1,$lang = "en") {
        $promotions = $cart['promotions'];

        //get available dishes into cart
        $dishes = Dish::whereIn('id', explode(',', $promotion->free_item))->where('active', 1)->select('id', "name_$lang as name", 'restaurant_id')->get();
        $dishes = self::getAvailableDishes($dishes);

        // update promotion
        if ($promotion['free_item_quantity']) {
            $promotion['free_item_quantity'] += $quantity;
        }
        else {
            $promotion['dishes'] = $dishes->toArray();
            $promotion['free_item'] = implode(', ', $dishes->pluck('id')->toArray());
            $promotion['selected_free_items'] = [];
            $promotion['free_item_quantity'] = $quantity;
            $promotion['selected_free_item_id'] = NULL;
        }
        return $cart;
    }

    public static function roundCurrency($value) {
        return round($value, 3);
    }

    public static function removeAllFreeItems($cart) {
        $cart['items'] = collect($cart['items'])->where('free_item', 0)->toArray();
        return $cart;
    }

    public static function getAllFreeItems($cart) {
        return collect($cart['items'])->where('free_item', 1)->toArray();
    }

    public static function searchFreeItem($cart, $promotion) {
        foreach($cart['items'] as $idx=>$cartItem) {
            if ($cartItem['free_item'] == 1 && $promotion->id == $cartItem['promotion_id']) return $idx;
        }
    }

    public static function calDiscountItem($restaurant_id, $cartItem, $promotion) {
        $discount = 0;
        $dishPrice = self::calDishPrice($cartItem, $promotion->include_request, false);
        if ($promotion->type == Promotion::PROMOTION_TYPES['%']) {
            $discount = self::getValueBeforeTax($restaurant_id, $dishPrice)*$promotion->value/100;
            $discount = $cartItem['quantity']*min($discount, $promotion->maximun_discount);
            return $discount;
        }
        else
        {
            $discount += $cartItem['quantity']*$promotion->value;
            return self::roundCurrency($discount, 3);
        }
    }

    public static function calVoucher($cart, $voucher) {
        if (!$voucher) return 0;
        $discount = 0;
        $subTotal = self::calculateSubTotal($cart);
        if($voucher->isAvailable($voucher) && $voucher->min_order_value <= $subTotal && $subTotal <= $voucher->max_order_value && $voucher->status == 1) {
            if ($voucher->type == Promotion::PROMOTION_TYPES['%'])
                $discount = $subTotal*$voucher->value/100;
            else {
                $discount = $voucher->value;
                $voucher->maximun_discount = $voucher->value;
            }
        }
        return self::roundCurrency(min($discount, $voucher->maximun_discount), 3);
    }

    public static function isVoucherValid($voucher, $cart, $lang=NULL) {
        $countPromoUsage = PromotionUsage::where('promotion_id', $voucher->id)->get()->count();
        return $voucher && $voucher->isValid($voucher->promotion_code) && ($countPromoUsage < $voucher->number_usage)
            && $voucher->min_order_value <= $cart['sub_total'] && $cart['sub_total'] <= $voucher->max_order_value
            && $voucher->status == 1;
    }

    public static function getTax($cart) {
        $restaurant = Restaurant::find($cart['restaurant_id']);
        return $restaurant->tax->rate ?? 0;
    }

    public static function getTaxType($cart) {
        $restaurant = Restaurant::find($cart['restaurant_id']);
        return $restaurant->tax->type ?? NULL;
    }

    public static function getAvailableDishes($dishes){
        foreach($dishes as $idx=>$dish) {
            if ($dish->getTBD() == false) {
                unset($dishes[$idx]);
            }
        }

        return $dishes;
    }

    public static function generalCheck($input){
        $cart = $input['cart'];
        $restaurant_slug = $input['restaurant_slug'];
        $restaurant_id = $input['restaurant_id'];
        $district_id = $input['district_id'];
        $ward_id = $input['ward_id'];
        $cart['location_info'] = [
          'district_id' => $district_id,
          'ward_id' => $ward_id
        ];
        // dd($cart);
        if($cart['restaurant'] == ''){
          $cart['restaurant'] = $restaurant_slug;
          $cart['restaurant_id'] = $restaurant_id;
        }
        if ($cart['restaurant'] != $restaurant_slug) {
            $cart = self::initCart([
                'min_order_amount' => $cart['min_order_amount'],
                'restaurant' => $restaurant_slug,
                'restaurant_id' => $restaurant_id,
                'district_id' => $district_id,
                'ward_id' => $ward_id,
            ]);
        }

        if ($cart['voucher']) {
            $voucher = Promotion::where('id', $cart['voucher']['id'])->where('status',1)->first();
            // remove voucher from Cart if it expired
            if (!$voucher || !$voucher->isAvailable()) $cart['voucher'] = NULL;
        }
        $cart = collect(self::updateCartInfo($cart));
        return $cart;
    }

    public static function verifyTBD($dish_tbds){
        $dish_show = false;

        foreach($dish_tbds as $dish_tbd){
            $dish_show = $dish_show || $dish_tbd->checkThis();
        }

        return $dish_show;
    }

    public static function Synchonize($cart){
      $dishes_changed = [];
      $dishes_disappear =[];
      $dish_id_in_cart = collect($cart['items'])->where('free_item', 0);
      $dishes_disappear = TBDService::checkMultipleDishes($dish_id_in_cart);
      $dishes_changed = TBPService::timeBasePricingMultiDish($dish_id_in_cart);
      return [$dishes_disappear,$dishes_changed];
    }
}
