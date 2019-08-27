<?php

namespace App\Services;

use App\Models\Restaurant;
use App\Models\PromotionAvailableTime;
use App\Models\PromotionAffect;
use Carbon\Carbon;
use App\Models\Dish;
use App\Models\DishCategory;
use App\Models\DishCustomization;
use App\Models\Category;
use App\Models\CategoryCustomization;
use App\Models\Customization;
use App\Models\CustomizationOption;
use App\Models\TimeBaseDisplayRule;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\Setting;
use App\Models\SettingKey;
use App\Models\Ward;
use App\Models\RestaurantDeliverySetting;
use App\Models\Tax;
use App\Models\TimeBaseDisplayAffect;
use DB;
use App\Services\TBPService;
use App\Services\TBDService;
use App\Services\TimeSettingService;
use App\Services\CartService;
use App\Services\CommonService;
use App\Services\ReviewService;
use App\Services\DateTimeHandleService;
use App\Services\Restaurant\RestaurantBuilderService;

class RestaurantService
{

    protected $timeSettingService;

    public function __construct(TimeSettingService $timeSettingService)
    {
        $this->timeSettingService = $timeSettingService;
    }

    public static function getCartForThisRestaurant($cart, $restaurant, $is_restaurant_page = false)
    {
        $cart['is_restaurant_page'] = $is_restaurant_page;
        $now = Carbon::now();
        $orderServices = collect($restaurant->orderServices());
        $orderPayments = collect($restaurant->orderPayments());
        if (count($orderServices) == 1) {
            $cart['service'] = $orderServices->keys()->first();
        }

        if (count($orderPayments) == 1) {
            $cart['payment'] = $orderPayments->keys()->first();
        } else {
            $cart['payment'] = '';
        }
        $cart = CartService::generalCheck([
            'cart' => $cart,
            'restaurant_slug' => $restaurant->restaurant_slug,
            'restaurant_id' => $restaurant->id,
            'district_id' => $restaurant->district_id,
            'ward_id' => $restaurant->ward_id
        ]);

        return $cart;
    }

    public static function getRestaurantFromRequest($request, $slug = "", $lang = "en", $extra_function = [])
    {
        if ($request->header('CLI-HEADER') != null) {
            $restaurant = RestaurantService::getRestaurantInfo([
                'restaurant_id' => $request->input('restaurant_id'),
                'district_id' => $request->input('district_id'),
                'ward_id' => $request->input('ward_id')
            ], $lang, $extra_function);
        } else {
            $district = $request->input('district');
            $wardInput = $request->input('ward');
            $ward = Ward::where('id', $wardInput)->first();
            $wardId = isset($ward->id) ? $ward->id : null;
            $restaurant = RestaurantService::getRestaurantInfo([
                'restaurant_slug' => $slug,
                'district_slug' => $district,
                'ward_id' => $wardId
            ], $lang, $extra_function);
        }
        if ($restaurant == null) {
            return null;
        }
        $restaurant->openStatus = self::getOpenStatus($restaurant->restaurantWorkTimes);
        return $restaurant;
    }

    public static function getRestaurantInfo($search_params = [], $lang = "en", $extra_function = [])
    {
        $district = null;
        $ward = null;
        $restaurant = Restaurant::leftJoin('taxes', 'taxes.restaurant_id', 'restaurants.id')
            ->join('restaurant_delivery_settings', 'restaurant_delivery_settings.restaurant_id', '=', 'restaurants.id')
            ->join('districts', 'districts.id', '=', 'restaurant_delivery_settings.district_id')
            ->where('restaurants.active', 1);
        if (array_key_exists('restaurant_id', $search_params) && array_key_exists('district_id', $search_params)) {
            $district = $search_params['district_id'];
            $restaurant->where('restaurants.id', '=', $search_params['restaurant_id'])
                ->where('restaurant_delivery_settings.district_id', '=', $search_params['district_id']);
        } else {
            if (array_key_exists('restaurant_slug', $search_params) && array_key_exists('district_slug',
                    $search_params)) {
                $district = $search_params['district_slug'];
                $restaurant->where('restaurants.slug', '=', $search_params['restaurant_slug'])
                    ->where('districts.slug', '=', $search_params['district_slug']);
            } else {
                return null;
            }
        }

        if ($search_params['ward_id'] !== null && $search_params['ward_id'] !== "" && $search_params['ward_id'] !== 0) {
            $restaurant = $restaurant->where(function ($query) use ($search_params) {
                $query = $query->whereNull('restaurant_delivery_settings.ward_id')->orWhere('restaurant_delivery_settings.ward_id',
                    '=', $search_params['ward_id']);
            });

        } else {
            $restaurant = $restaurant->whereNull('restaurant_delivery_settings.ward_id');
        }

        $restaurant->select('restaurants.id', "restaurants.name_$lang as name", "restaurants.slug as restaurant_slug",
            "restaurants.title_brief_$lang as title_brief", "restaurants.description_$lang as description",
            "restaurants.address_$lang as address", "restaurants.delivery", "restaurants.pickup",
            "restaurants.image as res_image",
            "restaurants.cod_payment", "restaurants.online_payment", "restaurants.phone", "restaurants.email",
            "restaurants.province_id", "restaurant_delivery_settings.district_id", "restaurants.take_red_bill",
            'restaurant_delivery_settings.delivery_cost as deliveryCost',
            'restaurant_delivery_settings.min_order_amount as minOrderAmount',
            "districts.name_$lang as districtName",
            "districts.slug as district_slug",
            "restaurant_delivery_settings.ward_id as ward_delivery",
            "restaurants.intro", "restaurants.vip_restaurant",
            'taxes.type', 'taxes.rate');
        $restaurant = call_user_func(RestaurantBuilderService::class . '::' . 'workingTimeBuilder', $restaurant, $lang);
        foreach ($extra_function as $func) {
            $restaurant = call_user_func(RestaurantBuilderService::class . '::' . $func, $restaurant, $lang);

        }
        $restaurant = $restaurant->first();
        if ($restaurant == null) {
            return null;
        }
        $restaurant = self::formatWorkingTime($restaurant);
        [$restaurant->star, $restaurant->count_review] = ReviewService::starAndCount($restaurant);
        return $restaurant;
    }

    public static function formatWorkingTime($restaurant)
    {
        if ($restaurant != null) {
            foreach ($restaurant->restaurantWorkTimes as &$workTime) {
                foreach ($workTime->time_setting->time_setting_details as &$time) {
                    $time->to_time = DateTimeHandleService::calculateHourOver24($time->to_time);
                }
            }
        }
        return $restaurant;
    }

    public static function getRestaurantMenu($restaurant_id = 0, $lang = "en")
    {
        // get categories has dishes

        $categories = self::getRestaurantCategories($restaurant_id, $lang);

//        $customizations = Customization::whereIn('id', $dish_customizations->pluck('customization_id'))
//            ->where('active', 1)
//            ->select('customizations.id', "customizations.name_$lang as name", 'customizations.price',
//                "customizations.description_$lang as description",
//                'customizations.required', 'customizations.has_options',
//                "customizations.selection_type", "customizations.quantity_changeable",
//                DB::raw("1 as min_quantity"), "customizations.max_quantity"
//            )
//            ->with([
//                'options' => function ($query) use ($lang) {
//                    $query->where('active', 1)
//                        ->select('customization_options.id', "customization_options.name_$lang as name",
//                            "customization_options.price", "customization_options.sequence",
//                            "customization_options.name_$lang as name", 'customization_options.customization_id')
//                        ->orderBy('customization_options.sequence');
//                }
//            ])->get();
        return $categories;
    }

    public static function getRestaurantCategories($restaurant_id = 0, $lang = "en")
    {
        $categories = Category::select('id', "title_$lang as title", 'active', DB::raw('0 as disabled'))
            ->where('restaurant_id', $restaurant_id)
            ->where('active', true)
            ->with([
                'timeBaseDisplayRule' => function ($query) {
                    $query->select('time_base_display_rules.id', 'time_base_display_rules.active',
                        'time_base_display_rules.mon', 'time_base_display_rules.tue', 'time_base_display_rules.wed',
                        'time_base_display_rules.thu', 'time_base_display_rules.fri', 'time_base_display_rules.sat',
                        'time_base_display_rules.sun', 'time_base_display_rules.period_type',
                        'time_base_display_rules.from_date',
                        'time_base_display_rules.to_date', 'time_base_display_rules.all_times',
                        'time_base_display_rules.from_time',
                        'time_base_display_rules.to_time', 'time_base_display_rules.all_days',
                        'time_base_display_affects.rule_id',
                        'time_base_display_affects.category_id')
                        ->where('time_base_display_rules.active', true);
                },
                'dishes' => function ($query) use ($lang) {
                    $query->select("dishes.id", "dishes.name_$lang as name","dishes.image", "dishes.description_$lang as description",
                        'dishes.price', 'dishes.slug', 'dishes.active', 'dishes.image', DB::raw('0 as disabled'))
                        ->where('dishes.active', true)
                        ->with([
                            'timeBaseDisplayRule' => function ($query) {
                                $query->select('time_base_display_rules.id', 'time_base_display_rules.active',
                                    'time_base_display_rules.mon', 'time_base_display_rules.tue',
                                    'time_base_display_rules.wed',
                                    'time_base_display_rules.thu', 'time_base_display_rules.fri',
                                    'time_base_display_rules.sat',
                                    'time_base_display_rules.sun', 'time_base_display_rules.period_type',
                                    'time_base_display_rules.from_date',
                                    'time_base_display_rules.to_date', 'time_base_display_rules.all_times',
                                    'time_base_display_rules.from_time',
                                    'time_base_display_rules.to_time', 'time_base_display_rules.all_days',
                                    'time_base_display_affects.rule_id',
                                    'time_base_display_affects.dish_id')
                                    ->where('time_base_display_rules.active', true);
                            },
                            'timeBasePricingRule' => function ($query) {
                                $query->select('time_base_pricing_rules.id', 'time_base_pricing_rules.active',
                                    'time_base_pricing_rules.mon', 'time_base_pricing_rules.tue',
                                    'time_base_pricing_rules.wed',
                                    'time_base_pricing_rules.thu', 'time_base_pricing_rules.fri',
                                    'time_base_pricing_rules.sat',
                                    'time_base_pricing_rules.sun', 'time_base_pricing_rules.period_type',
                                    'time_base_pricing_rules.from_date',
                                    'time_base_pricing_rules.to_date', 'time_base_pricing_rules.all_times',
                                    'time_base_pricing_rules.from_time',
                                    'time_base_pricing_rules.to_time', 'time_base_pricing_rules.all_days',
                                    'time_base_pricing_rules.type', 'time_base_pricing_rules.inscrease',
                                    'time_base_pricing_affects.rule_id',
                                    'time_base_pricing_affects.dish_id',
                                    'time_base_pricing_rules.value')
                                    ->where('time_base_pricing_rules.active', true);
                            },'customization' => function ($query) use ($lang) {
                                $query->select("customizations.id", "customizations.name_$lang as name",
                                    "customizations.description_$lang as description",
                                    'customizations.price', 'customizations.active', 'customizations.required',
                                    'customizations.has_options',
                                    'customizations.selection_type', 'customizations.max_quantity', 'customizations.min_quantity',
                                    'customizations.quantity_changeable')
                                    ->where('customizations.active', true)
                                    ->with([
                                        'options' => function ($query) use ($lang) {
                                            $query->select("customization_options.id", "customization_options.name_$lang as name",
                                                'customization_options.price',
                                                'customization_options.customization_id',
                                                'customization_options.active', 'customization_options.max_quantity',
                                                'customization_options.min_quantity');
                                        }
                                    ]);
                            }
                        ]);
                },
                'customization' => function ($query) use ($lang) {
                    $query->select("customizations.id", "customizations.name_$lang as name",
                        "customizations.description_$lang as description",
                        'customizations.price', 'customizations.active', 'customizations.required',
                        'customizations.has_options',
                        'customizations.selection_type', 'customizations.max_quantity', 'customizations.min_quantity',
                        'customizations.quantity_changeable')
                        ->where('customizations.active', true)
                        ->with([
                            'options' => function ($query) use ($lang) {
                                $query->select("customization_options.id", "customization_options.name_$lang as name",
                                    'customization_options.price',
                                    'customization_options.customization_id',
                                    'customization_options.active', 'customization_options.max_quantity',
                                    'customization_options.min_quantity');
                            }
                        ]);
                }
            ])->get();

        foreach ($categories as $ckey => $category) {
            $categories[$ckey]->dishes = $category->dishes;
            $categories[$ckey]->customization = $category->customization;
            if ($category->timeBaseDisplayRule->count() != 0 && !TBDService::checkTBDs($category->timeBaseDisplayRule)) {
                $category->disabled = 1;
//                unset($categories[$ckey]);
            } else {
                foreach ($category->dishes as $dkey => $dish) {
                    if ($dish->timeBaseDisplayRule->count() != 0 && !TBDService::checkTBDs($dish->timeBaseDisplayRule)) {
                        $dish->disabled = 1;
//                        unset($categories[$ckey]->dishes[$dkey]);
                    }
                    else {
                        $dish->price = TBPService::timeBasePricing($dish->timeBasePricingRule, $dish->price);
                        $dish->unsetRelation('timeBasePricingRule')->unsetRelation('timeBaseDisplayRule');
                    }
                }
                $categories[$ckey]->dishes = $categories[$ckey]->dishes->values();
            }
            $category->unsetRelation('timeBaseDisplayRule')->unsetRelation('customization')->unsetRelation('dishes');
        }
        $categories = $categories->values();
//        dd($categories[0]);
//        $catesIdHasDishes = DB::table('categories')
//            ->whereRaw("categories.restaurant_id = $restaurant_id")
//            ->whereRaw('categories.active = 1')
//            ->join('dishes_categories as dish_cates', 'dish_cates.category_id', '=', 'categories.id')
//            ->whereRaw('dish_cates.active = 1')
//            ->join('dishes', 'dishes.id', 'dish_cates.dish_id')
//            ->whereRaw('dishes.active = 1')
//            ->select('categories.id');
//
//        // get categories with tbd show
//        $categories = DB::table('time_base_display_affects as tbd_affs')
//            ->whereIn('tbd_affs.category_id', $catesIdHasDishes->pluck('id')->toArray())
//            ->whereNull('tbd_affs.dish_id')
//            ->join('categories', 'categories.id', '=', 'tbd_affs.category_id')
//            ->groupBy('tbd_affs.category_id')
//            ->select(DB::raw("categories.id, categories.title_$lang as title, categories.slug,
//            tbd_affs.category_id as id, group_concat(tbd_affs.rule_id) as rules_id"))
//            ->orderBy('categories.sequence', 'asc')
//            ->get();
//
//        $categoriesWithTbd = DB::table('time_base_display_affects as tbd_affs')
//            ->whereNotNull('tbd_affs.category_id')
//            ->where('tbd_affs.restaurant_id', $restaurant_id)
//            ->select('tbd_affs.category_id')
//            ->groupBy('tbd_affs.category_id')
//            ->get();
//        //get categories without time base display
//        $categoriesWithoutTbd = DB::table('categories')
//            ->where("categories.restaurant_id", $restaurant_id)
//            ->whereRaw('categories.active = 1')
//            ->whereNotIn('categories.id', $categoriesWithTbd->pluck('category_id')->toArray())
//            ->whereIn('categories.id', $catesIdHasDishes->pluck('id')->toArray())
//            ->get();
//        //get categories with and without time base display
//        $categoriesList = DB::table('time_base_display_affects as tbd_affs')
//            ->rightJoin('categories', 'categories.id', '=', 'tbd_affs.category_id')
//            ->whereIn('categories.id',
//                array_merge($categoriesWithoutTbd->pluck('id')->toArray(), $categories->pluck('id')->toArray()))
//            ->groupBy('categories.id')
//            ->select(DB::raw("categories.id as id, categories.title_$lang as title, categories.slug, categories.sequence, IF(ISNULL(group_concat(tbd_affs.rule_id)),'1',group_concat(tbd_affs.rule_id)) as rules_id"))
//            ->orderBy('categories.sequence', 'asc')
//            ->get();
//
//        $categories = $categoriesList;
//
//        $dishes = collect();
//        $dish_customizations = collect();
//        foreach ($categories as $key => $cate) {
//            $tbd = TBDService::getTBD($cate->rules_id);
//            if ($tbd == 0 || $tbd == -1) {
//                unset($categories[$key]);
//            } else {
//                // get dishes with tbd show
//                $cateDishes = DB::table('dishes')
//                    ->whereRaw("dishes.restaurant_id = $restaurant_id")
//                    ->whereRaw('dishes.active = 1')
//                    ->join('dishes_categories as dish_cates', 'dish_cates.dish_id', '=', 'dishes.id')
//                    ->whereRaw('dish_cates.active = 1')
//                    ->whereRaw("dish_cates.category_id = $cate->id")
//                    ->leftJoin('time_base_display_affects as tbd_affs', 'tbd_affs.dish_id', '=', 'dishes.id')
//                    ->groupBy('dishes.id')
//                    ->select(DB::raw("dishes.id,dishes.price, dishes.name_$lang as name, dishes.description_$lang as description, dish_cates.category_id as category_id,IF(ISNULL(group_concat(tbd_affs.rule_id)),'1',group_concat(tbd_affs.rule_id)) as rules_id"))
//                    ->orderBy('dish_cates.sequence', 'asc')
//                    ->get();
//
//                foreach ($cateDishes as $key => $dish) {
//                    $tbd = TBDService::getTBD($dish->rules_id);
//                    if ($tbd == 0 || $tbd == -1) {
//                        unset($cateDishes[$key]);
//                    } else {
//                        // get dishes customizations
//                        $cateCus = DB::table('categories_customizations as cate_cus')
//                            ->join('customizations', 'customizations.id', '=', 'cate_cus.customization_id')
//                            ->where('active', 1)
//                            ->where('cate_cus.restaurant_id', '=', $restaurant_id)
//                            ->whereRaw("category_id = $cate->id")
//                            ->select(DB::RAW("
//                            cate_cus.id, cate_cus.restaurant_id, cate_cus.customization_id, 'from_category' as cus_from
//                            "))
//                            ->get();
//                        $cateDishesCus = DB::table('dishes_customizations as dish_cus')
//                            ->join('customizations', 'customizations.id', '=', 'dish_cus.customization_id')
//                            ->where('active', 1)
//                            ->where('dish_cus.restaurant_id', '=', $restaurant_id)
//                            ->whereRaw("dish_id = $dish->id")
//                            ->select(DB::RAW("
//                            dish_cus.id, dish_cus.restaurant_id, dish_cus.customization_id, 'from_dish' as cus_from
//                            "))
//                            ->get();
//                        $dish_cus = $cateCus->merge($cateDishesCus);
//                        foreach ($dish_cus as $dish_cus_key => &$d) {
//                            $d->category_id = $cate->id;
//                            $d->dish_id = $dish->id;
//                            $filter = $dish_cus->where('customization_id', $d->customization_id)
//                                ->where('dish_id', $d->dish_id)
//                                ->where('category_id', $d->category_id);
//                            if ($filter->count() > 1 && $d->cus_from == "from_dish") {
//                                unset($dish_cus[$dish_cus_key]);
//                            }
//                        }
//
//                        $dish_customizations = $dish_customizations->merge($dish_cus);
//                    }
//                };
//                $dishes = $dishes->merge($cateDishes);
//            }
//        };
//        // dish time base pricing
//        foreach ($dishes as &$dish) {
//            $dish->price = TBPService::timeBasePricing($dish);
//        }
//
//        $dishes = $dishes->groupBy('category_id');
//
//        foreach ($categories as $key => &$category) {
//            $category->dishes = [];
//            if (array_key_exists($category->id, $dishes->toArray())) {
//                $category->dishes = $dishes[$category->id];
//            }
//        }

        return $categories;
    }

    public static function getRestaurantExchangeRate($restaurantId)
    {
        $exchange_rate = config('constants.EXCHANGE_RATE');
        $exchange = Setting::join('setting_keys', 'settings.key', '=', 'setting_keys.name')
            ->where('setting_keys.name', 'exchange_rate')
            ->where('settings.restaurant_id', $restaurantId)->first();
        if (!empty($exchange)) {
            if ($exchange->value > 0) {
                $exchange_rate = $exchange->value;
            }
        }
        return $exchange_rate;
    }

    public static function getOpenStatus($workTimesRules)
    {
        $now = Carbon::now();
        $status = false;
        foreach ($workTimesRules as $workTime) {
            $status = $status || TimeSettingService::checkTimeSetting($workTime->time_setting);
        }
        return $status;
    }

    public static function getLeaderBoardList($lang = en)
    {
        $restaurants = Restaurant::select("name_$lang as name", "title_brief_$lang as title_brief",
            "image")->limit(10)->get();
        $restaurants = $restaurants->map(function ($restaurant) {
            $restaurant->image = CommonService::buildImageURL($restaurant->image);
            return $restaurant;
        });
        return $restaurants;
    }
}
