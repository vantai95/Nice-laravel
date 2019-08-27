<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Models\RestaurantDeliverySetting;
use App\Notifications\ExpoNotification;
use App\Models\User;
use App\Models\Tax;
use App\Services\CartService;
use DB;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $cart = Session::get('cart');
        $item = $request->input('item');
        $cart = CartService::doAdd($cart,$item);

        Session::put('cart',$cart);
        return response()->json(['data'=>$cart]);
    }

    public function subtractFromCart($index){
        $cart = Session::get('cart')->toArray();

        array_splice($cart['items'],$index,1);

        $cart = CartService::updateCartInfo($cart);

        Session::put('cart',collect($cart));
        return response()->json(['data'=>$cart]);
    }


    public function saveCart(Request $request){
        $cart = $request->post('cart');
        $slug = $cart['restaurant'];
        $district = $request->input('district');

        // check promotion
        $promotionChange = CartService::isCartPromotionsChange($cart);
        if($promotionChange == true) {
            Session::flash('flash_error', "Promotion changed! Please retry");
            return redirect("/restaurants/$slug?district=$district");
        }

        $cart = CartService::updateCartInfo($cart);
        Session::put('cart',collect($cart));
        return response()->json(['data'=>$cart]);
    }

    public function dishAmountChange(Request $request,$index){
        $cart = Session::get('cart')->toArray();
        $quantity = $request->input('quantity');
        if(!$quantity || $quantity <= 0){
            $cart['items'][$index]['quantity'] = 1;
        }else{
            $cart['items'][$index]['quantity'] = $quantity;
        }

        $cart = CartService::updateCartInfo($cart);

        Session::put('cart',collect($cart));
        return response()->json(['data'=>Session::get('cart')]);
    }

    public function reOrder(Request $request){

        $old_order_info = $request->input('old_order_info');
        $items = $request->input('items');
        $restaurant_slug = $old_order_info['restaurant_slug'];

        $cart = CartService::initCart([
            'restaurant' => $restaurant_slug,
            'restaurant_id' => $old_order_info['restaurant_id'],
        ]);

        $tax_info = Tax::where('restaurant_id','=',$old_order_info['restaurant_id'])->first();
        $cart['tax'] = $old_order_info['restaurant_id'];
        $cart['checkbill'] = $old_order_info['take_red_invoice'];
        $cart['tax_type'] = isset($tax_info->type) ? $tax_info->type : -1;

        foreach($items as $item){
            $cart = CartService::doAdd($cart,$item);
        }
        $delivery_fee = RestaurantDeliverySetting::where('restaurant_id','=',$old_order_info['restaurant_id'])
        ->where('district_id','=',$old_order_info['district_id'])->first();
        $cart['delivery_fee'] = $delivery_fee['delivery_cost'];
        $cart['payment'] = $old_order_info['payment_method'];
        $cart['service'] = $old_order_info['order_type'];
        $cart = CartService::updateCartInfo($cart);
        Session::put('cart',collect($cart));
        return response()->json(['error'=>0]);
    }

    public function Synchonize(Request $request){
      $cart = Session::get('cart');
      [$dishes_disappear,$dishes_changed] = CartService::Synchonize($cart);
      if(count($dishes_disappear) > 0){
          return response()->json(['dishes_disappear'=>true,'dishes_disappear_list' => $dishes_disappear]);
      }
      if(count($dishes_changed) > 0){
          return response()->json(['dishes_changed'=>true,'dishes_changed_list' => $dishes_changed]);
      }
    }

    public function CheckSession(){
        $cart = Session::get('cart')->toArray();
        dd($cart);
    }

    public function clearSession(){
        Session::forget('cart');
    }
}
