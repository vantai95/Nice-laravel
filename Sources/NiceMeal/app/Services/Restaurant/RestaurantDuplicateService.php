<?php
namespace App\Services\Restaurant;
use App\Models\Promotion;
use App\Models\PromotionAvailableTime;
use App\Models\PromotionAffect;
use App\Models\Category;
use App\Models\CategoryCustomization;
use App\Models\Comment;
use App\Models\CommissionHistory;
use App\Models\CommissionRule;
use App\Models\Customization;
use App\Models\CustomizationOption;
use App\Models\Dish;
use App\Models\DishCategory;
use App\Models\DishCustomization;
use App\Models\GroupCustomization;
use App\Models\Group;
use App\Models\Printer;
use App\Models\PromotionUsage;
use App\Models\RestaurantDeliverySetting;
use App\Models\RestaurantWorkTime;
use App\Models\RestaurantCuisine;
use App\Models\Review;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Tax;
use App\Models\TimeBaseDisplayAffect;
use App\Models\TimeBaseDisplayRule;
use App\Models\TimeBasePricingAffect;
use App\Models\TimeBasePricingRule;
use App\Models\TimeSetting;
use App\Models\TimeSettingDetail;
use App\Models\Upload;
use App\Models\UsersRestaurant;
use DB;

class RestaurantDuplicateService{

    //duplicate restaurant
    public static function dupRestaurant($res) {
        DB::beginTransaction();
        try{
            $newRes = $res->replicate();

            $newRes->name_en = $newRes->name_en ." Copy";
            $newRes->name_ja = $newRes->name_ja ." Copy";
            $newRes->active = false;
            $newRes->sequence = $newRes->sequence + 1;
            $newRes->save();

            self::dupCustomize($res, $newRes);
            self::dupCategory($res, $newRes);
            self::dupCateCustom($res, $newRes);
            self::dupComment($res, $newRes);
            self::dupCommissionHistory($res, $newRes);
            self::dupCommissionRule($res, $newRes);
            self::dupDishes($res, $newRes);
            self::dupDishCate($res, $newRes);
            self::dupDishCustom($res, $newRes);
            self::dupGroup($res, $newRes);
            self::dupGroupCustom($res, $newRes);
            self::dupPrinter($res, $newRes);
            self::dupPromotion($res, $newRes);
            self::dupPromotionUsages($res, $newRes);
            self::dupDelivery($res, $newRes);
            self::dupWorkingTime($res, $newRes);
            self::dupResCuisines($res, $newRes);
            self::dupReview($res, $newRes);
            self::dupRoles($res, $newRes);
            self::dupSetting($res, $newRes);
            self::dupTaxes($res, $newRes);
            self::dupTBDRules($res, $newRes);
            self::dupTBDAffect($res, $newRes);
            self::dupTBPRules($res, $newRes);
            self::dupTBPAffect($res, $newRes);
            self::dupUploads($res, $newRes);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
    //customization
    public static function dupCustomize($res, $newRes) {
        DB::beginTransaction();
        try {
            $customizationData = $res->customization;
            if(!empty($customizationData)) {
                foreach ($customizationData as $value) {
                    $customizationInfo = [
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'restaurant_id' => $newRes->id,
                        'name_en' => $value->name_en,
                        'name_ja' => $value->name_ja,
                        'description_en' => $value->description_en,
                        'description_ja' => $value->description_ja,
                        'price' => $value->price,
                        'active' => $value->active,
                        'required' => $value->required,
                        'has_options' => $value->has_options,
                        'selection_type' => $value->selection_type,
                        'max_quantity' => $value->max_quantity,
                        'min_quantity' => $value->min_quantity,
                        'quantity_changeable' => $value->quantity_changeable,
                    ];
                    // create new customization
                    $newCustomization = Customization::create($customizationInfo);

                    // get options of new customization
                    $options = $value->options;
                    $newOptions = [];

                    foreach ($options as $option) {
                        $newOptionInfo = [
                            'created_at' => date('Y-m-d h:i:s'),
                            'updated_at' => date('Y-m-d h:i:s'),
                            'restaurant_id' => $newRes->id,
                            'customization_id' => $newCustomization->id,
                            'name_en' => $option->name_en,
                            'name_ja' => $option->name_ja,
                            'price' => $option->price,
                            'active' => $option->active,
                            'max_quantity' => $option->max_quantity,
                            'min_quantity' => $option->min_quantity,
                        ];
                        array_push($newOptions,$newOptionInfo);
                    }
                    if(!empty($newOptions)) {
                        CustomizationOption::insert($newOptions);
                    }
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
    //category
    public static function dupCategory($res, $newRes) {
        DB::beginTransaction();
        try {
            $categoryData = $res->dishCategory();
            if(!empty($categoryData)) {
                $categoryDatas = [];
                foreach ($categoryData as $value) {
                    $categoryInfo = [
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'restaurant_id' => $newRes->id,
                        'title_en' => $value->title_en,
                        'title_ja' => $value->title_ja,
                        'image' => $value->image,
                        'active' => $value->active,
                        'slug' => $value->slug,
                        'sequence' => $value->sequence,
                    ];
                    array_push($categoryDatas, $categoryInfo);
                }
                Category::insert($categoryDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
    //category_customization
    public static function dupCateCustom($res, $newRes) {
        DB::beginTransaction();
        try {
            $categoryCustomizationData = $res->categoryCustomization;
            if(!empty($categoryCustomizationData)) {
                $categoryCustomizationDatas = [];

                foreach ($categoryCustomizationData as $value) {
                    // get new category_id by old category_id and old name
                    $oldCategory = Category::find($value->category_id);
                    $newCategory = null;
                    if($oldCategory) {
                        $newCategory = Category::where('restaurant_id',$newRes->id)->where('title_en',$oldCategory->title_en)->first();
                    }

                    // get new customization_id by old customization_id and old name
                    $oldCustomization = Customization::find($value->customization_id);
                    $newCustomization = null;
                    if($oldCustomization) {
                        $newCustomization = Customization::where('restaurant_id',$newRes->id)->where('name_en',$oldCustomization->name_en)->first();
                    }

                    if($newCategory && $newCustomization) {
                        $categoryCustomizationInfo = [
                            'created_at' => date('Y-m-d h:i:s'),
                            'updated_at' => date('Y-m-d h:i:s'),
                            'restaurant_id' => $newRes->id,
                            'customization_id' => $newCustomization->id,
                            'category_id' => $newCategory->id,
                        ];
                        array_push($categoryCustomizationDatas, $categoryCustomizationInfo);
                    }
                }
                CategoryCustomization::insert($categoryCustomizationDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
    //comment
    public static function dupComment($res, $newRes) {
        DB::beginTransaction();
        try {
            $commentData = $res->Comment;
            if(!empty($commentData)) {
                $commentDatas = [];
                foreach ($commentData as $value) {
                    $commentInfo = [
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'restaurant_id' => $newRes->id,
                        'user_id' => $value->user_id,
                        'title' => $value->title,
                        'content' => $value->content,
                        'food_rate' => $value->food_rate,
                        'service_rate' => $value->service_rate,
                    ];
                    array_push($commentDatas, $commentInfo);
                }
                Comment::insert($commentDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
    //Commission_History
    public static function dupCommissionHistory($res, $newRes) {
        DB::beginTransaction();
        try{
            $commissionHistoryData = $res->commissionHistory;
            if(!empty($commissionHistoryData)) {
                $commissionHistoryDatas = [];
                foreach ($commissionHistoryData as $value) {
                    $commissionHistoryInfo = [
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'restaurant_id' => $newRes->id,
                        'date_from' => $value->date_from,
                        'date_to' => $value->date_to,
                        'commission' => $value->commission,
                        'online_payment' => $value->online_payment,
                        'pay_for_commission' => $value->pay_for_commission,
                        'unpaid_commission' => $value->unpaid_commission,
                        'money_returned' => $value->money_returned,
                    ];
                    array_push($commissionHistoryDatas, $commissionHistoryInfo);
                }
                CommissionHistory::insert($commissionHistoryDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e){
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //Commission_Rule
    public static function dupCommissionRule($res, $newRes){
        DB::beginTransaction();
        try{
            $commissionRuleData = $res->commissionRule;
            if(!empty($commissionRuleData)) {
                $commissionRuleDatas = [];
                foreach ($commissionRuleData as $value) {
                    $commissionRuleInfo = [
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'restaurant_id' => $newRes->id,
                        'level' => $value->level,
                        'total_from' => $value->total_from,
                        'total_to' => $value->total_to,
                        'rate' => $value->rate,
                    ];
                    array_push($commissionRuleDatas, $commissionRuleInfo);
                }
                CommissionRule::insert($commissionRuleDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //Dishes
    public static function dupDishes($res, $newRes) {
        DB::beginTransaction();
        try{
            $dishesData = $res->dishes();
            if(!empty($dishesData)) {
                $dishesDatas = [];
                foreach ($dishesData as $value) {
                    $dishesInfo = [
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'restaurant_id' => $newRes->id,
                        'category_id' => $value->category_id,
                        'name_en' => $value->name_en,
                        'name_ja' => $value->name_ja,
                        'description_en' => $value->description_en,
                        'description_ja' => $value->description_ja,
                        'price' => $value->price,
                        'active' => $value->active,
                        'slug' => $value->slug,
                        'group_id' => $value->group_id,
                    ];
                    array_push($dishesDatas, $dishesInfo);
                }
                Dish::insert($dishesDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //dishes_category
    public static function dupDishCate($res, $newRes) {
        DB::beginTransaction();
        try{
            $dishCategoryData = $res->dishCategoriesTable();
            if(!empty($dishCategoryData)) {
                $dishCategoryDatas = [];
                foreach ($dishCategoryData as $value) {
                    //get new dish_id by old dish_id and old_name
                    $oldDish = Dish::find($value->dish_id);
                    $newDish = null;
                    if($oldDish) {
                        $newDish = Dish::where('restaurant_id',$newRes->id)->where('name_en',$oldDish->name_en)->first();
                    }
                    //get new category_id by old category_id and old name
                    $oldCate = Category::find($value->category_id);
                    $newCategory = null;
                    if($oldCate) {
                        $newCategory = Category::where('restaurant_id',$newRes->id)->where('title_en',$oldCate->title_en)->first();
                    }

                    if($newDish && $newCategory) {
                        $dishCategoryInfo = [
                            'created_at' => date('Y-m-d h:i:s'),
                            'updated_at' => date('Y-m-d h:i:s'),
                            'restaurant_id' => $newRes->id,
                            'category_id' => $newCategory->id,
                            'dish_id' => $newDish->id,
                            'active' => $value->active,
                            'sequence' => $value->sequence,
                        ];
                        array_push($dishCategoryDatas, $dishCategoryInfo);
                    }
                }
                DishCategory::insert($dishCategoryDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //dishes_custom
    public static function dupDishCustom($res, $newRes) {
        DB::beginTransaction();
        try{
            $dishCustomizationData = $res->dishCustomization;
            if(!empty($dishCustomizationData)) {
                $dishCustomizationDatas = [];
                foreach ($dishCustomizationData as $value) {
                    //get new dish_id
                    $oldDish = Dish::find($value->dish_id);
                    $newDish = null;
                    if($oldDish) {
                        $newDish = Dish::where('restaurant_id',$newRes->id)->where('name_en',$oldDish->name_en)->first();
                    }

                    //get new customization_id
                    $oldCustomization = Customization::find($value->customization_id);
                    $newCustomization = null;
                    if($oldCustomization) {
                        $newCustomization = Customization::where('restaurant_id',$newRes->id)->where('name_en',$oldCustomization->name_en)->first();
                    }

                    if($newDish && $newCustomization) {
                        $dishCustomizationInfo = [
                            'created_at' => date('Y-m-d h:i:s'),
                            'updated_at' => date('Y-m-d h:i:s'),
                            'restaurant_id' => $newRes->id,
                            'customization_id' => $newCustomization->id,
                            'dish_id' => $newDish->id,
                        ];
                        array_push($dishCustomizationDatas, $dishCustomizationInfo);
                    }
                }
                DishCustomization::insert($dishCustomizationDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //group
    public static function dupGroup($res, $newRes) {
        DB::beginTransaction();
        try{
            $groupData = $res->groups;
            if(!empty($groupData)) {
                $groupDatas = [];
                foreach ($groupData as $value) {
                    $groupInfo = [
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'restaurant_id' => $newRes->id,
                        'name' => $value->name,
                        'active' => $value->active,
                    ];
                    array_push($groupDatas, $groupInfo);
                }
                Group::insert($groupDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //group_custom
    public static function dupGroupCustom($res, $newRes) {
        DB::beginTransaction();
        try{
            $groupCustomData = $res->groupCustomizaiton;
            if(!empty($groupCustomData)) {
                $groupCustomDatas = [];
                foreach ($groupCustomData as $value) {
                    //get new group_id
                    $oldGroup = Group::find($value->group_id);
                    $newGroup = null;
                    if($oldGroup) {
                        $newGroup = Group::where('restaurant_id',$newRes->id)->where('name',$oldGroup->name)->first();
                    }

                    //get new customization_id
                    $oldCustomization = Customization::find($value->customization_id);
                    $newCustomization = null;
                    if($oldCustomization) {
                        $newCustomization = Customization::where('restaurant_id',$newRes->id)->where('name_en',$oldCustomization->name_en)->first();
                    }

                    if($newGroup && $newCustomization) {
                        $groupCustomInfo = [
                            'created_at' => date('Y-m-d h:i:s'),
                            'updated_at' => date('Y-m-d h:i:s'),
                            'restaurant_id' => $newRes->id,
                            'group_id' => $newGroup->id,
                            'customization_id' => $newCustomization->id,
                            'active' => $value->active,
                        ];
                        array_push($groupCustomDatas, $groupCustomInfo);
                    }
                }
                GroupCustomization::insert($groupCustomDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //printer
    public static function dupPrinter($res, $newRes) {
        DB::beginTransaction();
        try{
            $printerData = $res->printer;
            if(!empty($printerData)) {
                $printerDatas = [];
                foreach ($printerData as $value) {
                    $printerInfo = [
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'restaurant_id' => $newRes->id,
                        'name' => $value->name,
                        'token' => $value->token,
                        'auto_print' => $value->auto_print,
                        'page_header' => $value->page_header,
                        'page_footer' => $value->page_footer,
                        'reject_reason' => $value->reject_reason,
                        'printer_status' => $value->printer_status,
                        'check_interval' => $value->check_interval,
                        'ip' => $value->ip,
                        'port' => $value->port,
                        'polling_url' => $value->polling_url,
                        'callback_url' => $value->callback_url,
                        'last_time_success' => $value->last_time_success,
                    ];
                    array_push($printerDatas, $printerInfo);
                }
                Printer::insert($printerDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //promotion
    public static function dupPromotion($res, $newRes) {
        DB::beginTransaction();
        try{
            $promotionData = $res->promotions;
            if(!empty($promotionData)) {
                foreach ($promotionData as $value) {
                    $promotionInfo = [
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'name_en' => $value->name_en,
                        'name_ja' => $value->name_ja,
                        'description_en' => $value->description_en,
                        'description_ja' => $value->description_ja,
                        'image' => $value->image,
                        'promotion_code' => $value->promotion_code,
                        'restaurant_id' => $newRes->id,
                        'is_global' => $value->is_global,
                        'type' => $value->type,
                        'value' => $value->value,
                        'free_item' => $value->free_item,
                        'created_by' => $value->created_by,
                        'maximun_discount' => $value->maximun_discount,
                        'number_usage' => $value->number_usage,
                        'apply_to' => $value->apply_to,
                        'min_order_value' => $value->min_order_value,
                        'max_order_value' => $value->max_order_value,
                        'item_value_from' => $value->item_value_from,
                        'item_value_to' => $value->item_value_to,
                        'status' => $value->status,
                        'include_request' => $value->include_request,
                    ];
                    //greate new promotion
                    $newPromotion = Promotion::create($promotionInfo);

                    //get available time of new promotion
                    self::dupTimeSetting($newRes, $value, $newPromotion);
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //promotion_affect
    public static function dupPromotionAffects($res, $newRes) {
        DB::beginTransaction();
        try{
            $promotionAffectData = $res->promotionAffects;
            if(!empty($promotionAffectData)) {
                $promotionAffectDatas = [];
                foreach ($promotionAffectData as $value) {
                    //get new promotion_id
                    $oldPromotion = Promotion::find($value->promotion_id);
                    $newPromotion = null;
                    if($oldPromotion) {
                        $newPromotion = Promotion::where('restaurant_id',$newRes->id)->where('name_en',$oldPromotion->name_en)->first();
                    }

                    //get new dish_id
                    $oldDish = Dish::find($value->dish_id);
                    $newDish = null;
                    if($oldDish) {
                        $newDish = Dish::where('restaurant_id',$newRes->id)->where('name_en',$oldDish->name_en)->first();
                    }

                    //get new category_id;
                    $oldCategory = Category::find($value->category_id);
                    $newCategory = null;
                    if($oldCategory) {
                        $newCategory = Category::where('restaurant_id',$newRes->id)->where('title_en',$oldCategory->title_en)->first();
                    }

                    if($newPromotion && ($newDish || $newCategory)) {
                        $promotionAffectInfo = [
                            'created_at' => date('Y-m-d h:i:s'),
                            'updated_at' => date('Y-m-d h:i:s'),
                            'promotion_id' => $newPromotion->id,
                            'restaurant_id' => $newRes->id,
                            'dish_id' => $newDish ? $newDish->id : null,
                            'category_id' => $newCategory ? $newCategory->id : null,
                        ];
                        array_push($promotionAffectDatas, $promotionAffectInfo);
                    }
                }
                PromotionAffect::insert($promotionAffectDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //Promotion_Usages
    public static function dupPromotionUsages($res, $newRes) {
        DB::beginTransaction();
        try{
            $promotionUsageData = $res->promotionUsages;
            if(!empty($promotionUsageData)) {
                $promotionUsageDatas = [];
                foreach ($promotionUsageData as $value) {
                    //get new promotion_id
                    $oldPromotion = Promotion::find($value->promotion_id);
                    $newPromotion = null;
                    if($oldPromotion) {
                        $newPromotion = Promotion::where('restaurant_id',$newRes->id)->where('name_en',$oldPromotion->name_en)->first();
                    }

                    if($newPromotion) {
                        $promotionUsageInfo = [
                            'created_at' => date('Y-m-d h:i:s'),
                            'updated_at' => date('Y-m-d h:i:s'),
                            'order_id' => $value->order_id,
                            'restaurant_id' => $newRes->id,
                            'promotion_id' => $newPromotion->id,
                            'promotion_value' => $newPromotion->value,
                            'free_item_id' => $value->free_item_id,
                        ];
                        array_push($promotionUsageDatas, $promotionUsageInfo);
                    }
                }
                PromotionUsage::insert($promotionUsageDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //delivery
    public static function dupDelivery($res, $newRes) {
        DB::beginTransaction();
        try{
            $deliveryData = $res->restaurantDeliverySetting;
            if(!empty($deliveryData)) {
                foreach ($deliveryData as $value) {
                    if($value->parent_id == 0) {
                        $parentDeliveryInfo = [
                            'created_at' => date('Y-m-d h:i:s'),
                            'updated_at' => date('Y-m-d h:i:s'),
                            'restaurant_id' => $newRes->id,
                            'district_id' => $value->district_id,
                            'delivery_cost' => $value->delivery_cost,
                            'min_order_amount' => $value->min_order_amount,
                            'from' => $value->from,
                            'to' => $value->to,
                            'parent_id' => $value->parent_id,
                            'ward_id' => $value->ward_id,
                        ];

                        RestaurantDeliverySetting::create($parentDeliveryInfo);
                    }else {
                        //get new delivery by old restaurant id
                        $oldParentDelivery = RestaurantDeliverySetting::find($value->parent_id);
                        $newParentDelivery = RestaurantDeliverySetting::where('restaurant_id',$newRes->id)
                            ->where('district_id',$oldParentDelivery->district_id)
                            ->where('parent_id',$oldParentDelivery->parent_id)->first();

                        $deliveryInfo = [
                            'created_at' => date('Y-m-d h:i:s'),
                            'updated_at' => date('Y-m-d h:i:s'),
                            'restaurant_id' => $newRes->id,
                            'district_id' => $value->district_id,
                            'delivery_cost' => $value->delivery_cost,
                            'min_order_amount' => $value->min_order_amount,
                            'from' => $value->from,
                            'to' => $value->to,
                            'parent_id' => $newParentDelivery->id,
                            'ward_id' => $value->ward_id,
                        ];

                        RestaurantDeliverySetting::create($deliveryInfo);
                    }
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //working_time
    public static function dupWorkingTime($res, $newRes) {
        DB::beginTransaction();
        try{
            $workTimeData = $res->restaurantWorkTimes;
            if(!empty($workTimeData)) {
                $workTimeDatas = [];
                foreach ($workTimeData as $value) {
                    $workTimeInfo = [
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'restaurant_id' => $newRes->id,
                        'all_days' => $value->all_days,
                        'sun' => $value->sun,
                        'mon' => $value->mon,
                        'tue' => $value->tue,
                        'wed' => $value->wed,
                        'thu' => $value->thu,
                        'fri' => $value->fri,
                        'sat' => $value->sat,
                        'all_times' => $value->all_times,
                        'from_time' => $value->from_time,
                        'to_time' => $value->to_time,
                        'from_date' => $value->from_date,
                        'to_date' => $value->to_date,
                        'period_type' => $value->period_type,
                    ];
                    $newWorkingTime = RestaurantWorkTime::create($workTimeInfo);

                    self::dupTimeSetting($newRes, $value, $newWorkingTime);
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //restaurant_cuisines
    public static function dupResCuisines($res, $newRes) {
        DB::beginTransaction();
        try{
            $restaurantCuisineData = $res->restaurantCuisines;
            if(!empty($restaurantCuisineData)) {
                $restaurantCuisineDatas = [];
                foreach ($restaurantCuisineData as $value) {
                    $restaurantCuisineInfo = [
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'restaurant_id' => $newRes->id,
                        'cuisine_id' => $value->cuisine_id,
                    ];
                    array_push($restaurantCuisineDatas, $restaurantCuisineInfo);
                }
                RestaurantCuisine::insert($restaurantCuisineDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //review
    public static function dupReview($res, $newRes) {
        DB::beginTransaction();
        try{
            $reviewData = $res->reviews;
            if(!empty($reviewData)) {
                $reviewDatas = [];
                foreach ($reviewData as $value) {
                    $reviewInfo = [
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'restaurant_id' => $newRes->id,
                        'order_id' => $value->order_id,
                        'customer_id' => $value->customer_id,
                        'food_rate' => $value->food_rate,
                        'service_rate' => $value->service_rate,
                        'comment' => $value->comment,
                        'status' => $value->status,
                        'published' => $value->published,
                        'confirm_token' => $value->confirm_token,
                        'problem_solve_token' => $value->problem_solve_token,
                    ];
                    array_push($reviewDatas, $reviewInfo);
                }
                Review::insert($reviewDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //Roles
    public static function dupRoles($res, $newRes) {
        DB::beginTransaction();
        try{
            $rolesData = $res->roles;
            if(!empty($rolesData)) {
                $rolesDatas = [];
                foreach ($rolesData as $value) {
                    $rolesInfo = [
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'restaurant_id' => $newRes->id,
                        'name' => $value->name,
                        'permissions' => $value->permissions,
                    ];
                    array_push($rolesDatas, $rolesInfo);
                }
                Role::insert($rolesDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //Setting
    public static function dupSetting($res, $newRes) {
        DB::beginTransaction();
        try{
            $settingData = $res->settings;
            if(!empty($settingData)) {
                $settingDatas = [];
                foreach ($settingData as $value) {
                    $settingInfo = [
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'restaurant_id' => $newRes->id,
                        'key' => $value->key,
                        'value' => $value->value,
                    ];
                    array_push($settingDatas, $settingInfo);
                }
                Setting::insert($settingDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //Taxes
    public static function dupTaxes($res, $newRes) {
        DB::beginTransaction();
        try{
            $taxesData = $res->taxes;
            if(!empty($taxesData)) {
                $taxesDatas = [];
                foreach ($taxesData as $value) {
                    $taxesInfo = [
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'restaurant_id' => $newRes->id,
                        'rate' => $value->rate,
                        'type' => $value->type,
                    ];
                    array_push($taxesDatas, $taxesInfo);
                }
                Tax::insert($taxesDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //timeBase_Display_Rules
    public static function dupTBDRules($res, $newRes) {
        DB::beginTransaction();
        try{
            $TBDRuleData = $res->timeBaseDisplayRules();
            if(!empty($TBDRuleData)) {
                $TBDRuleDatas = [];
                foreach ($TBDRuleData as $value) {
                    $TBDRuleInfo = [
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'restaurant_id' => $newRes->id,
                        'name' => $value->name,
                        'active' => $value->active,
                        'all_days' => $value->all_days,
                        'sun' => $value->sun,
                        'mon' => $value->mon,
                        'tue' => $value->tue,
                        'wed' => $value->wed,
                        'thu' => $value->thu,
                        'fri' => $value->fri,
                        'sat' => $value->sat,
                        'period_type' => $value->period_type,
                        'from_date' => $value->from_date,
                        'to_date' => $value->to_date,
                        'all_times' => $value->all_times,
                        'from_time' => $value->from_time,
                        'to_time' => $value->to_time,
                    ];
                    array_push($TBDRuleDatas, $TBDRuleInfo);
                }
                TimeBaseDisplayRule::insert($TBDRuleDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //timeBase_Display_Affect
    public static function dupTBDAffect($res, $newRes) {
        DB::beginTransaction();
        try{
            $TBDAffectData = $res->timeBaseDisplayAffect();
            if(!empty($TBDAffectData)) {
                $TBDAffectDatas = [];
                foreach ($TBDAffectData as $value) {
                    //get new rule_id
                    $oldRule = TimeBaseDisplayRule::find($value->rule_id);
                    $newRule = null;
                    if($oldRule) {
                        $newRule = TimeBaseDisplayRule::where('restaurant_id',$newRes->id)->where('name',$oldRule->name)->first();
                    }

                    //get new category_id
                    $oldCategory = Category::find($value->category_id);
                    $newCategory = null;
                    if($oldCategory) {
                        $newCategory = Category::where('restaurant_id',$newRes->id)->where('title_en',$oldCategory->title_en)->first();
                    }

                    //get new dish_id
                    $oldDish = Dish::find($value->dish_id);
                    $newDish = null;
                    if($oldDish) {
                        $newDish = Dish::where('restaurant_id',$newRes->id)->where('name_en',$oldDish->name_en)->first();
                    }

                    //get new group_id
                    $oldGroup = Group::find($value->group_id);
                    $newGroup = null;
                    if($oldGroup) {
                        $newGroup = Group::where('restaurant_id',$newRes->id)->where('name',$oldGroup->name)->first();
                    }

                    if($newRule && ($newCategory || $newDish || $newGroup)) {
                        $TBDAffectInfo = [
                            'created_at' => date('Y-m-d h:i:s'),
                            'updated_at' => date('Y-m-d h:i:s'),
                            'restaurant_id' => $newRes->id,
                            'rule_id' => $newRule ? $newRule->id : null,
                            'category_id' => $newCategory ? $newCategory->id : null,
                            'dish_id' => $newDish ? $newDish->id : null,
                            'group_id' => $newGroup ? $newGroup->id : null,
                        ];
                        array_push($TBDAffectDatas, $TBDAffectInfo);
                    }
                }
                TimeBaseDisplayAffect::insert($TBDAffectDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //timeBase_Pricing_Rules
    public static function dupTBPRules($res, $newRes) {
        DB::beginTransaction();
        try{
            $TBPRuleData = $res->timeBasePricingRules();
            if(!empty($TBPRuleData)) {
                $TBPRuleDatas = [];
                foreach ($TBPRuleData as $value) {
                    $TBPRuleInfo = [
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'restaurant_id' => $newRes->id,
                        'name' => $value->name,
                        'active' => $value->active,
                        'period_type' => $value->period_type,
                        'all_days' => $value->all_days,
                        'from_date' => $value->from_date,
                        'to_date' => $value->to_date,
                        'sun' => $value->sun,
                        'mon' => $value->mon,
                        'tue' => $value->tue,
                        'wed' => $value->wed,
                        'thu' => $value->thu,
                        'fri' => $value->fri,
                        'sat' => $value->sat,
                        'all_times' => $value->all_times,
                        'from_time' => $value->from_time,
                        'to_time' => $value->to_time,
                        'type' => $value->type,
                        'value' => $value->value,
                        'inscrease' => $value->inscrease,
                    ];
                    array_push($TBPRuleDatas, $TBPRuleInfo);
                }
                TimeBasePricingRule::insert($TBPRuleDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //timeBase_Pricing_Affect
    public static function dupTBPAffect($res, $newRes) {
        DB::beginTransaction();
        try{
            $TBPAffectData = $res->timeBasePricingAffect();
            if(!empty($TBPAffectData)) {
                $TBPAffectDatas = [];
                foreach ($TBPAffectData as $value) {
                    //get new rule_id
                    $oldRule = TimeBasePricingRule::find($value->rule_id);
                    $newRule = null;
                    if($oldRule) {
                        $newRule = TimeBasePricingRule::where('restaurant_id',$newRes->id)->where('name',$oldRule->name)->first();
                    }

                    //get new dish_id
                    $oldDish = Dish::find($value->dish_id);
                    $newDish = null;
                    if($oldDish) {
                        $newDish = Dish::where('restaurant_id',$newRes->id)->where('name_en',$oldDish->name_en)->first();
                    }

                    if($newRule && $newDish) {
                        $TBPAffectInfo = [
                            'created_at' => date('Y-m-d h:i:s'),
                            'updated_at' => date('Y-m-d h:i:s'),
                            'restaurant_id' => $newRes->id,
                            'rule_id' => $newRule ? $newRule->id : null,
                            'dish_id' => $newDish ? $newDish->id : null,
                        ];
                        array_push($TBPAffectDatas, $TBPAffectInfo);
                    }
                }
                TimeBasePricingAffect::insert($TBPAffectDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //time_setting
    /*params: new restaurant, records, object
     * */
    public static function dupTimeSetting($newRes, $oldObject, $newObject) {
        //$oldResWorkingTime -> $oldObject, $newResWorkingTime -> $newObject
        DB::beginTransaction();
        try{
            $oldObject->load('time_setting');
            $timeSettingDatas = $oldObject->time_setting;
            if($timeSettingDatas != null) {
                $timeSettingInfo = [
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'object_type' => $timeSettingDatas->object_type,
                        'object_id' => $newObject->id,
                        'all_days' => $timeSettingDatas->all_days,
                        'sun' => $timeSettingDatas->sun,
                        'mon' => $timeSettingDatas->mon,
                        'tue' => $timeSettingDatas->tue,
                        'wed' => $timeSettingDatas->wed,
                        'thu' => $timeSettingDatas->thu,
                        'fri' => $timeSettingDatas->fri,
                        'sat' => $timeSettingDatas->sat,
                        'all_times' => $timeSettingDatas->all_times,
                        'period_type' => $timeSettingDatas->period_type,
                        'from_date' => $timeSettingDatas->from_date,
                        'to_date' => $timeSettingDatas->to_date,
                        'restaurant_id' => $newRes->id,
                        'special_date' => $timeSettingDatas->special_date,
                        'has_special_date' => $timeSettingDatas->has_special_date,
                    ];
                    $newTimeSetting = TimeSetting::create($timeSettingInfo);
                    self::dupTimeSettingDetail($timeSettingDatas, $newTimeSetting);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //time_setting_detail
    public static function 
    dupTimeSettingDetail($oldTimeSetting, $newTimeSetting) {
        DB::beginTransaction();
        try{
            $TimeSettingDetailData = $oldTimeSetting->time_setting_details()->where('time_setting_id','=',$oldTimeSetting['id'])->get();
            if(!empty($TimeSettingDetailData)) {
                $TimeSettingDetailDatas = [];
                foreach ($TimeSettingDetailData as $value) {
                    $TimeSettingDetailInfo = [
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'time_setting_id' => $newTimeSetting->id,
                        'from_time' => $value->from_time,
                        'to_time' => $value->to_time,
                    ];
                    array_push($TimeSettingDetailDatas, $TimeSettingDetailInfo);
                }
                TimeSettingDetail::insert($TimeSettingDetailDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    //uploads
    public static function dupUploads($res, $newRes) {
        DB::beginTransaction();
        try{
            $uploadsData = $res->uploads;
            if(!empty($uploadsData)) {
                $uploadsDatas = [];
                foreach ($uploadsData as $value) {
                    $uploadsInfo = [
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s'),
                        'restaurant_id' => $newRes->id,
                        'file_name' => $value->file_name,
                        'extension' => $value->extension,
                        'user_id' => $value->user_id,
                    ];
                    array_push($uploadsDatas, $uploadsInfo);
                }
                Upload::insert($uploadsDatas);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}