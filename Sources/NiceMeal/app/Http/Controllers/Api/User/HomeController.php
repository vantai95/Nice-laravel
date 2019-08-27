<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemCustomization;
use App\Models\OrderCustomerInfo;
use App\Models\Role;
use App\Models\Dish;
use App\Models\Restaurant;
use App\Models\UsersRestaurant;
use App\Models\Printer;
use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use App\Models\Promotion;
use App\Services\PromotionService;
use App\Services\RestaurantService;
use App\Services\CommonService;
use App\Services\ReviewService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Restaurant\SearchService;
use App, DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{

    public function getProvinceAndDistrict(Request $request){
        $lang = $request->header('language');
            \Illuminate\Support\Facades\App::setLocale($lang);
            $province = Province::select('id',"name_$lang as name")
            ->with(['districts' => function($query) use($lang){
                $query->select('id',"name_$lang as name","province_id")
                ->with(['wards' => function($query) use ($lang){
                    $query->select('id',"name_$lang as name","district_id");
                }]);
            }])->get();
        try {

        } catch (\Exception $exception) {
            return response()->json([
                "success" => false,
                "error_code" => "COMMON01",
                "message" => "Error, please check you params"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $province
        ]);
    }

    /**
     * @api {GET} /api/districts Get District Info
     * @apiName Districts
     * @apiVersion 1.0.0
     * @apiDescription Return District and Ward Info
     * @apiGroup HOMEPAGE
     * @apiHeader {String} CLI-HEADER The key to access API server
     * @apiHeader {String} LANGUAGE Language Code
     * @apiSuccessExample Success Response
     *       HTTP/1.1 200 OK
     *       {
     *         "success": true,
     *         "data":[{
     *            "id": 1,
     *            "name": "District 1",
     *            "wards":[
     *               {
     *                 "id": 1,
     *                 "name": "Ben Thanh"
     *               }]
     *            },
     *            {
     *              "id": 2,
     *              "name": "District 2",
     *              "wards":[
     *                 {
     *                    "id": 12,
     *                    "name": "Thao Dien"
     *                 }]
     *           }]
     *        }
     *
     * @apiSuccessExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "success": false
     *       "error_code": "COMMON01"
     *       "message": "Error, please check you params"
     *     }
     */
    public function getWardsAndDistricts(Request $request)
    {
        try {
            $lang = $request->header('language');
            \Illuminate\Support\Facades\App::setLocale($lang);
            $data = District::get();
            $wards = Ward::all();
            foreach ($data as &$district) {
                $district['wards'] = $wards->where('district_id', $district->id);
            }
        } catch (\Exception $exception) {
            return response()->json([
                "success" => false,
                "error_code" => "COMMON01",
                "message" => "Error, please check you params"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * @api {GET} /api/filter_param Get Filter Param
     * @apiName Filter Param
     * @apiVersion 1.0.0
     * @apiDescription Return list Param in filter
     * @apiGroup RESTAURANTS
     * @apiHeader {String} CLI-HEADER The key to access API server
     * @apiHeader {String} LANGUAGE Language Code
     * @apiSuccessExample Success Response
     *       HTTP/1.1 200 OK
     *       {
     *          "success": true,
     *          "data":{
     *             "cuisines": [
     *             {
     *                 "id": 0,
     *                 "name": "All"
     *             },
     *             {
     *                 "id": 1,
     *                 "name": "Italian"
     *             },
     *             {
     *                 "id": 2,
     *                 "name": "American"
     *             }],
     *             "categories": [
     *             {
     *                 "id": 0,
     *                 "name": "All"
     *             },
     *             {
     *                 "id": 1,
     *                 "name": "Breakfast - Lunch - Dinner"
     *             },
     *             {
     *                  "id": 2,
     *                  "name": "Pizza - Pasta - Panini"
     *             }],
     *             "status": [
     *             {
     *                 "id": 1,
     *                 "name": "New",
     *             },
     *             {
     *                 "id": 2,
     *                 "name": "NoStatus",
     *             },
     *             {
     *                 "id": 3,
     *                 "name": "Promotion",
     *             },
     *             {
     *                 "id": 4,
     *                 "name": "Popular",
     *             },
     *             {
     *                 "id": 5,
     *                 "name": "Hight Quality",
     *             }],
     *             "services": [
     *                 "Delivery",
     *                 "Pickup"
     *             ],
     *             "payment_methods": [
     *                 "COD",
     *                 "Online Payment"
     *            ]
     *          }
     *        }
     *
     * @apiSuccessExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "success": false
     *       "error_code": "RESTAURANT00"
     *       "message": "Error, please check you params"
     *     }
     */


    /**
     * @api {GET} /api/search-restaurants?district_id=:district_id&ward_id=:ward_id Search Restaurant
     * @apiName Search  Restaurant
     * @apiVersion 1.0.0
     * @apiDescription Return restaurant list
     * @apiGroup RESTAURANTS
     *
     * @apiHeader {String} CLI-HEADER The key to access API server
     * @apiHeader {String} LANGUAGE Language Code
     *
     * @apiParam {Integer} district_id District Id
     * @apiParam {Integer} ward_id Ward Id
     * @apiParam {String} [cuisine] Filter by Cuisine
     * @apiParam {String} [category] Filter by Category
     * @apiParam {String} [status] Filter by Status
     * @apiParam {String} [service] Filter by Service(delivery or pickup)
     * @apiParam {String} [payment] Filter by Payment Method(cod_payment or online_payment)
     * @apiParam {String} [keyword] Filter by KeyWord
     *
     * @apiSuccessExample Success Response
     *       HTTP/1.1 200 OK
     *       {
     *          "success": true,
     *          "data":[{
     *            "id": 1,
     *            "name": "Oh!MyMeal",
     *            "description": "Italian, Pizza-Pasta-Panini",
     *            "status": 1,
     *            "logo": "http://localhost:8000/common-assets/img/restaurant_image.jpg",
     *            "working_status": "Open Now",
     *            "address": "Bình Thạnh District",
     *            "service": [
     *                 "pickup",
     *            ],
     *            "payment_method": [
     *                 "online_payment",
     *                 "cod_payment"
     *            ],
     *            "delivery_cost": "19.000 VNĐ",
     *            "min_order_delivery_cost": "99.000 VNĐ"
     *            },
     *            {
     *            "id": 2,
     *            "name": "My Sushi",
     *            "description": "Japanese, Sushi - Kimbab - Roli",
     *            "status": 1,
     *            "logo": "http://localhost:8000/common-assets/img/restaurant_image.jpg",
     *            "working_status": "Open Now",
     *            "address": "District 7",
     *            "service": [
     *                "delivery"
     *            ],
     *            "payment_method":[
     *                "online_payment",
     *                "cod_payment"
     *            ],
     *            "delivery_cost": "9.000 VNĐ",
     *            "min_order_delivery_cost": "99.000 VNĐ"
     *          }]
     *        }
     *
     * @apiSuccessExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "success": false
     *       "error_code": "RESTAURANT01"
     *       "message": "Error, please check you params"
     *     }
     */
    public function searchRestaurant(Request $request)
    {
        try {
            $requestData = $request->all();
            $segIdx = $request->get('segIdx');
            $lang = $request->header('language');
            App::setLocale($lang);
            $district_id = intval($request->get('district_id'));
            $ward_id = $request->get('ward_id');
            $keyword = $request->get('keyword');
            $status = explode(',',$request->get('status'));
            $cuisine = explode(',',$request->get('cuisine'));
            $category = explode(',',$request->get('category'));
            $services = explode(',',$request->get('services'));
            $payment_methods = explode(',',$request->get('payment_methods'));

            $condition = [
              'cuisines' => $cuisine,
              'categories' => $category,
              'statuses' => $status,
              'services' => $services,
              'payment_methods' => $payment_methods
            ];

            $sort = ["key" => "", "direction" => "asc"];
            [$restaurants, $maxCount] = SearchService::searchByLocation(['district' => $district_id, 'ward' => $ward_id],
            $condition, $sort, $request->input('segIdx'),$lang);
        } catch (\Exception $exception) {
            return response()->json([
                "success" => false,
                "error_code" => "COMMON02",
                "message" => $exception->getMessage()
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $restaurants
        ]);
    }

    /**
     * @api {GET} /api/restaurant_info/:restaurant_id Restaurant Info
     * @apiName Restaurant Info
     * @apiVersion 1.0.0
     * @apiDescription Return restaurant info
     * @apiGroup RESTAURANTS
     *
     * @apiHeader {String} CLI-HEADER The key to access API server
     * @apiHeader {String} LANGUAGE Language Code
     * @apiParam {Integer} restaurant_id Restaurant ID
     *
     * @apiSuccessExample Success Response
     *       HTTP/1.1 200 OK
     *       {
     *          "success": true,
     *          "data": {
     *            "id": 1,
     *            "name": "Oh!MyMeal",
     *            "description": "Italian, Pizza-Pasta-Panii",
     *            "status": 1,
     *            "logo": "http://localhost:8000/common-assets/img/restaurant_image.jpg",
     *            "working_status": "Open Now",
     *            "address": "Bình Thạnh District",
     *            "service": [
     *                "Pickup",
     *                "Delivery"
     *            ],
     *            "payment_method":  [
     *                "Online Payment",
     *                "COD"
     *            ],
     *            "delivery_cost": "19.000 VNĐ",
     *            "min_order_delivery_cost": "99.000 VNĐ" ,
     *            "working_times": [
     *              {
     *                 "day": "Monday",
     *                 "value": "10:30 AM - 22:00 PM"
     *              },
     *              {
     *                 "day": "Tueday",
     *                 "value": "10:30 AM - 22:00 PM"
     *              },
     *              {
     *                 "day": "Wednesday",
     *                 "value": "10:30 AM - 22:00 PM"
     *              },
     *              {
     *                 "day": "Thursday",
     *                 "value": "10:30 AM - 22:00 PM"
     *              },
     *              {
     *                 "day": "Friday",
     *                 "value": "10:30 AM - 22:00 PM"
     *              },
     *              {
     *                 "day": "Saturday",
     *                 "value": "10:30 AM - 22:00 PM"
     *              },
     *              {
     *                 "day": "Sunday",
     *                 "value": "10:30 AM - 22:00 PM"
     *              }
     *            ],
     *            "delivery_settings": [
     *              {
     *                 "id": 1,
     *                 "location": "District 1",
     *                 "minimum_order_value": "99.000 VNĐ",
     *                 "minimum_order_value_unit": 99000,
     *                 "delivery_fee": "19.000 VNĐ",
     *                 "delivery_unit": 19000,
     *                 "order_value_from": 99000,
     *                 "order_value_to": 199000
     *              },
     *              {
     *                 "id": 2,
     *                 "location": "District 1",
     *                 "minimum_order_value": "200.000 VNĐ",
     *                 "minimum_order_value_unit": 200000,
     *                 "delivery_fee": "0 VNĐ",
     *                 "delivery_unit": 0,
     *                 "order_value_from": 200000,
     *                 "order_value_to": 2000000
     *              }
     *            ],
     *            "categories": [
     *              {
     *                "id": 1,
     *                "name": "Soft Drink",
     *                "sequence": 1,
     *                "dishes":[
     *                  {
     *                    "id": 1,
     *                    "name": "Coke",
     *                    "sequence": 1,
     *                    "price": "30.000 VNĐ",
     *                    "price_unit": 30000
     *                  },
     *                  {
     *                     "id": 2,
     *                     "name": "Sprite",
     *                     "sequence": 2,
     *                     "price": "50.000 VNĐ",
     *                     "price_unit": 50000
     *                  }
     *                 ]
     *               },
     *               {
     *                 "id": 2,
     *                 "name": "Asian Meal",
     *                 "sequence": 2,
     *                 "dishes": [
     *                   {
     *                     "id":3,
     *                     "name":"Egg fried rice",
     *                     "sequence":1,
     *                     "price": "80.000 VNĐ",
     *                     "price_unit":80000
     *                   },
     *                   {
     *                     "id":4,
     *                     "name":"Pork fried rice",
     *                     "sequence":2,
     *                     "price": "110.000 VNĐ",
     *                     "price_unit":110000
     *                   },
     *                 ]
     *               }
     *            ]
     *          }
     *        }
     *
     * @apiSuccessExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "success" : false
     *       "error_code": "RESTAURANT02"
     *       "message": "Error, please check you params"
     *     }
     */



}
