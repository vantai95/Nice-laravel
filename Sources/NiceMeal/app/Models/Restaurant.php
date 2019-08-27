<?php

namespace App\Models;

use Carbon\Carbon;
use Log, Session, DB;
use App\Models\DishCustomization;
use App\Services\TBDService;
use App\Http\Controllers\Controller;
use App\Services\DateTimeHandleService;


class Restaurant extends AppModel
{
    /**
     * The required variables
     */
    var $table = 'restaurants';
    var $slug = 'name_en';
    var $imagePath = 'constants.UPLOAD.RESTAURANT_IMAGE';
    var $defaultImagePath = 'constants.UPLOAD.RESTAURANT_IMAGE';

    /**
     * The model constants value
     */
    const STATUSES_FILTER = [
        'popular' => '0',
        'new' => '1',
        'promotion' => '2',
        'high quality' => '3',
        'no status' => '4'
    ];
    const STATUS_FILTER = [
        'active' => 'active',
        'inactive' => 'inactive'
    ];
    const SERVICES_FILTER = [
        'delivery' => 'Delivery',
        'pickup' => 'Pickup',
        'discovery' => 'Discovery',
        'book_table' => 'Book Table'
    ];
    const PAYMENTS_FILTER = [
        'cod_payment' => 'COD',
        'online_payment' => 'Online Payment',
    ];

    /**
     * The database primary key value.
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     */
    protected $fillable = ['name_en', 'name_ja', 'highlight_label_en', 'highlight_label_ja', 'title_brief_en', 'title_brief_ja',
        'description_en', 'description_ja', 'address_en', 'address_ja', 'province_id', 'district_id', 'ward_id', 'phone',
        'email', 'banner', 'image', 'review_rate', 'otp', 'otp_value', 'active', 'status', 'latitude', 'longitude',
        'online_payment', 'cod_payment', 'delivery', 'pickup', 'vip_restaurant', 'published', 'tags', 'slug','owner_name','owner_email','owner_phone', 'link','take_red_bill', 'maximum_discount','contract','identity_card','business_license','intro','sequence','note','faqs','tax_type'];

    /**
     * Methods
     */
    public function getCustomizationList(){
        $customizationList = DB::table('customizations')
            ->select(DB::raw('customizations.*'))
            ->where('customizations.restaurant_id','=',$this->id)->get();
        return $customizationList ? $customizationList : '';
    }

    public function getGroupCustomization(){
        $customizationList = DB::table('customizations')
            ->join('group_customizations')
            ->select(DB::raw('DISTINCT customizations.*'))
            ->where('group_customizations.customization_id', '=', 'customizations.id')
            ->where('customizations.restaurant_id','=',$this->id)->get();

        return $customizationList ? $customizationList : '';
    }

    public function getTimeBaseDisplayRule(){
        $timeBaseDisplay = DB::table('time_base_display_rules')
            ->select(DB::raw('time_base_display_rules.*'))
            ->where('time_base_display_rules.restaurant_id','=',$this->id)
            ->where('time_base_display_rules.active', true)->get();
        return $timeBaseDisplay ? $timeBaseDisplay : '';
    }

    public function getTimeBasePricingRule(){
        $timeBasePricing = DB::table('time_base_pricing_rules')
            ->select(DB::raw('time_base_pricing_rules.*'))
            ->where('time_base_pricing_rules.restaurant_id','=',$this->id)
            ->where('time_base_pricing_rules.active', true)->get();
        return $timeBasePricing ? $timeBasePricing : '';
    }
    //category
    public function dishCategory(){
        return $this->hasMany('App\Models\Category','restaurant_id')->get();
    }
    //category_customization
    public function categoryCustomization(){
        return $this->hasMany('App\Models\CategoryCustomization','restaurant_id');
    }
    //comment
    public function Comment(){
        return $this->hasMany('App\Models\Comment','restaurant_id');
    }
    //commission_history
    public function commissionHistory(){
        return $this->hasMany('App\Models\CommissionHistory','restaurant_id');
    }
    //commission_rule
    public function commissionRule(){
        return $this->hasMany('App\Models\CommissionRule','restaurant_id');
    }
    //customization_option
    public function customizationOption(){
        return $this->hasMany('App\Models\CustomizationOption','restaurant_id');
    }
    //customization
    public function customization(){
        return $this->hasMany('App\Models\Customization','restaurant_id');
    }
    //dishes
    public function dishes() {
        return $this->hasMany('App\Models\Dish', 'restaurant_id')->get();
    }
    //dish_category
    public function dishCategoriesTable(){
        return $this->hasMany('App\Models\DishCategory','restaurant_id')->get();
    }
    //dish_customization
    public function dishCustomization(){
        return $this->hasMany('App\Models\DishCustomization','restaurant_id');
    }
    //favourites
    public function favourite(){
        return $this->hasMany('App\Models\Favourite','restaurant_id');
    }
    //group_customization
    public function groupCustomizaiton(){
        return $this->hasMany('App\Models\GroupCustomization','restaurant_id');
    }
    //groups
    public function groups(){
        return $this->hasMany('App\Models\Group','restaurant_id');
    }
    //order
    public function orders(){
        return $this->hasMany('App\Models\Order','restaurant_id');
    }
    //printer
    public function printer(){
        return $this->hasMany('App\Models\Printer','restaurant_id');
    }
    //promotion_affects
    public function promotionAffects(){
        return $this->hasMany('App\Models\PromotionAffect','restaurant_id');
    }
    //promotion_usages
    public function promotionUsages(){
        return $this->hasMany('App\Models\PromotionUsage','restaurant_id');
    }
    //promotions
    public function promotions(){
        return $this->hasMany('App\Models\Promotion', 'restaurant_id');
    }
    //Delivery_Setting
    public function restaurantDeliverySetting(){
        return $this->hasMany('App\Models\RestaurantDeliverySetting','restaurant_id');
    }
    //WorkTimes
    public function restaurantWorkTimes(){
        return $this->hasMany('App\Models\RestaurantWorkTime','restaurant_id');
    }
    //restaurans_cuisines
    public function restaurantCuisines(){
        return $this->hasMany('App\Models\RestaurantCuisine','restaurant_id');
    }
    //reviews
    public function reviews(){
        return $this->hasMany('App\Models\Review','restaurant_id');
    }
    //roles
    public function roles(){
        return $this->hasMany('App\Models\Role','restaurant_id');
    }
    //settings
    public function settings(){
        return $this->hasMany('App\Models\Setting','restaurant_id');
    }
    //taxes
    public function taxes(){
        return $this->hasMany('App\Models\Tax','restaurant_id');
    }
    //timeBase_Display_Affect
    public function timeBaseDisplayAffect(){
        return $this->hasMany('App\Models\TimeBaseDisplayAffect','restaurant_id')->get();
    }
    //timeBase_Display_Rules
    public function timeBaseDisplayRules(){
        return $this->hasMany('App\Models\TimeBaseDisplayRule','restaurant_id')->get();
    }
    //timeBase_Pricing_Affect
    public function timeBasePricingAffect(){
        return $this->hasMany('App\Models\TimeBasePricingAffect','restaurant_id')->get();
    }
    //timeBase_Pricing_Rules
    public function timeBasePricingRules(){
        return $this->hasMany('App\Models\TimeBasePricingRule','restaurant_id')->get();
    }
    //uploads
    public function uploads(){
        return $this->hasMany('App\Models\Upload','restaurant_id');
    }
    //users_restaurants
    public function usersRestaurants(){
        return $this->hasMany('App\Models\UsersRestaurant','restaurant_id');
    }

    public function maxDeliveryCost() {
        $maxDeliveryCost = RestaurantDeliverySetting::where('restaurant_id', $this->id)->max('delivery_cost');
        return !empty($maxDeliveryCost) ? $maxDeliveryCost : '---';
    }

    public function minOrderAmount() {
        $deliverySettings = RestaurantDeliverySetting::where('restaurant_id', $this->id)->first();
        return !empty($deliverySettings->min_order_amount) ? $deliverySettings->min_order_amount : '---';
    }

    public function orderServices() {
        $orderServices = [];
        foreach (Restaurant::SERVICES_FILTER as $key=>$value) {
            if ($this[$key] == 1)
                $orderServices[$key] = $value;
        }
        return $orderServices;
    }

    public function orderPayments() {
        $otherPayments = [];
        foreach (Restaurant::PAYMENTS_FILTER as $key=>$value) {
            if ($this[$key] == 1)
                $otherPayments[$key] = $value;
        }
        return $otherPayments;
    }

    public static function getRestaurantVipList() {
        return array(
            '' => 'NON_VIP',
            '1' => 'VIP'
        );
    }

    public function workTime() {
        $workTimes = RestaurantWorkTime::where('restaurant_id', $this->id)->get();

        // convert time to minutes
        foreach($workTimes as $key=>&$workTime) {
            if ($workTime->all_times == 1) {
                $workTime->time = range(0, 23*60+59);
            }
            else {
                // $fromTime = explode(':', $workTime->from_time);
                // $toTime = explode(':', $workTime->to_time);

                $fromTime = explode(':', '18:00:00');
                $toTime = explode(':', '18:00:00');

                $workTime->time = range($fromTime[0] * 60 + $fromTime[1], $toTime[0] * 60 + $toTime[1]);
            }
        }

        $workingTimes = [];
        foreach(Controller::WEEKNAME as $dayName) {
            $workingTimes[$dayName] = [];
            foreach ($workTimes as $key => &$workTime) {
                if ($workTime[$dayName] == 1) {
                    $workingTimes[$dayName] = self::arrayUnion($workingTimes[$dayName], $workTime->time);
                }
            }
        }
        foreach ($workingTimes as $key=>&$workTime) {
            $workTime = self::arr2ArrCont($workTime);
        };

        foreach ($workingTimes as $key=>&$workTimeDay) {
            foreach($workTimeDay as $key=>&$time) {
                $fromTime = (int)($time[0]/60) . ':' . $time[0]%60;
                if((int)($time[count($time)-1]/60) >=24)
                    $toTime = ((int)($time[count($time)-1]/60)-24) . ':' . $time[count($time)-1]%60;
                else
                    $toTime = (int)($time[count($time)-1]/60) . ':' . $time[count($time)-1]%60;
                $time[count($time)-1] = $time[count($time)-1] - 24;
                $time = [
                    Carbon::parse($fromTime)->format('h:i A'),
                    Carbon::parse($toTime)->format('h:i A')
                ];
            }
        };

        return $workingTimes;
    }

    public static function arrayUnion($x, $y)
    {
        return array_merge(
            array_intersect ($x, $y),
            array_diff($x, $y),
            array_diff($y, $x)
        );
    }

    // convert array to multiple array cont
    public static function arr2ArrCont($arr) {
        $resArr = [];
        $childArr = [];
        $arrL = count($arr);
        sort($arr);
        foreach($arr as $key=>$item) {
            if ($key == 0)
                array_push($childArr, $item);
            else if ($key == $arrL-1) {
                array_push($childArr, $item);
                array_push($resArr, $childArr);
            }
            else if(($item - $arr[$key-1]) > 1) {
                array_push($resArr, $childArr);
                $childArr = [];
                array_push($childArr, $item);
            }
            else
                array_push($childArr, $item);
        }
        return $resArr;
    }

    public function resStatus(){
        if($this->status == 0){
            return 'Popular';
        }
        else if($this->status == 1){
            return 'New';
        }
        else if($this->status == 2){
            return 'Promotion';
        }
        else if($this->status == 3){
            return 'High quality';
        }
        else {
            return 'No status';
        }
    }

    public function tax() {
        return $this->hasOne('\App\Models\Tax');
    }

}
