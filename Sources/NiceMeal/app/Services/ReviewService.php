<?php
namespace App\Services;

use App\Models\Order;
use App\Models\Review;
use Carbon\Carbon;
use DB;

class ReviewService{


    /**
     * Multiple restaurant function
     */


    public static function getStarWeekForMultiRestaurant($restaurant_list){

        $all_reviews = Review::where('published',true)->whereIn('restaurant_id',$restaurant_list->pluck('id'))->get();
        $review_list = self::getReviews_Multi_restaurant($restaurant_list);
        $order_list = self::getOrders_Multi_restaurant($restaurant_list);
        foreach($restaurant_list as &$restaurant){
            $review_of_restaurant = $review_list->where('restaurant_id','=',$restaurant->id);
            $star_week = self::calculateStar($review_of_restaurant);
            $total_week = self::calculateTotalWeek($order_list->where('restaurant_id','=',$restaurant->id));
            $restaurant->review = [
                'star' => self::calculateFinalStar($total_week,$star_week),
                'count_review' => $all_reviews->where('restaurant_id','=',$restaurant->id)->count()
            ];
        }
        return $restaurant_list;
    }

    public static function getReviews_Multi_restaurant($restaurant_list){
        $today = new Carbon();
        $review_list = Review::select('reviews.*')->whereIn('restaurant_id',$restaurant_list->pluck('id'))
        ->select('id','order_id','customer_id','restaurant_id','food_rate','service_rate')
        ->where(\DB::raw('WEEK(reviews.created_at)'),$today->weekOfYear - 1)
        ->where(DB::raw('YEAR(reviews.created_at)'),$today->year)
        ->where('published',true)->get();
        return $review_list;
    }

    public static function getOrders_Multi_restaurant($restaurant_list){
        $today = new Carbon();
        $order_list = Order::select('orders.total_amount')->whereIn('restaurant_id',$restaurant_list->pluck('id'))
            ->where(DB::raw('WEEK(orders.created_at)'),$today->weekOfYear - 1)
            ->where(DB::raw('YEAR(orders.created_at)'),$today->year)
            ->get();
        return $order_list;
    }
     /**
      * Single restaurant function
      */


      public static function starAndCount($restaurant){
        $count = self::getPublishedReviews_Single_Restaurant($restaurant)->count();
        $star = self::getReviewStar_Single_Restaurant($restaurant);
        return [$star,$count];
      }

      public static function getPublishedReviews_Single_Restaurant($restaurant){
            $review_builder = Review::where('reviews.published',true)->where('reviews.restaurant_id',$restaurant->id)
            ->select('reviews.id','reviews.order_id','reviews.customer_id','reviews.restaurant_id',DB::raw('UNIX_TIMESTAMP(reviews.created_at) as created_time'),
            'reviews.food_rate','reviews.service_rate','reviews.comment','reviews.status',
            'reviews.published','reviews.order_id','order_customer_infos.full_name')
            ->join('order_customer_infos','order_customer_infos.order_id','=','reviews.order_id');
            return $review_builder  ;
      }

      public static function getOrders_Single_Restaurant($restaurant){
        $today = new Carbon();
        $order_list = Order::select('orders.total_amount')->where('restaurant_id',$restaurant->id)
            ->where(DB::raw('WEEK(orders.created_at)'),$today->weekOfYear - 1)
            ->where(DB::raw('YEAR(orders.created_at)'),$today->year)
            ->get();
        return $order_list;
      }

      public static function getReviews_Single_Restaurant($restaurant){
        $today = new Carbon();
        $review_list = Review::select('reviews.*')->where('restaurant_id',$restaurant->id)
        ->select('id','order_id','customer_id','restaurant_id','food_rate','service_rate')
        ->where(\DB::raw('WEEK(reviews.created_at)'),$today->weekOfYear - 1)
        ->where(DB::raw('YEAR(reviews.created_at)'),$today->year)
        ->where('published',true)->get();
        return $review_list;
      }

      public static function getReviewStar_Single_Restaurant($restaurant){
        $total_week = self::getTotalWeek_Single_Restaurant($restaurant);
        $star_week = self::getStarWeek_Single_Restaurant($restaurant);

        return self::calculateFinalStar($total_week,$star_week);

      }

      public static function getTotalWeek_Single_Restaurant($restaurant){
        $today = new Carbon();
        $result_order = Order::select('orders.total_amount')->where('restaurant_id',$restaurant->id)
            ->where(DB::raw('WEEK(orders.created_at)'),$today->weekOfYear - 1)
            ->where(DB::raw('YEAR(orders.created_at)'),date('y'))
            ->get();
        return self::calculateTotalWeek($result_order);
    }

    public static function getStarWeek_Single_Restaurant($restaurant){
        $today = new Carbon();
        $result_review = Review::select('reviews.*')->where('restaurant_id',$restaurant->id)
        ->where(DB::raw('WEEK(reviews.created_at)'),$today->weekOfYear - 1)
        ->where(DB::raw('YEAR(reviews.created_at)'),$today->year)
        ->where('published',true)->get();

        $star_week = self::calculateStar($result_review);

        return $star_week;
    }

      /**
       * Genernal function
       */
    public static function calculateTotalWeek($order_list){
        $total_week = 0;
        foreach ($order_list as $item) {
            $total_week += $item->total_amount;
        }
        if(count($order_list)) {
            $total_week = $total_week / count($order_list);
        }
        return $total_week;
    }

      public static function calculateFinalStar($total_week, $star_week){
        $star = 0;
        $result = ($total_week / 500000) + ($star_week/ 10);
        if($result < 0.4) {
            $star = 0;
        } else if( $result < 0.8) {
            $star = 1;
        } else if($result < 1.2  ) {
            $star = 2;
        } else if($result < 1.6  ) {
            $star = 3;
        }
        else if($result < 2.0  ) {
            $star = 4;
        }
        else {
            $star = 5;
        }
        return $star;
    }

    public static function calculateStar($result_review){
        $star_week = 0;
        $star_food_week = 0;
        $star_service_week = 0;
        foreach ($result_review as $item) {
            $star_food_week += $item->food_rate;
            $star_service_week += $item->service_rate;
        }
        if(count($result_review)) {
            $star_week = (($star_food_week / count($result_review)) + ($star_service_week / count($result_review))) / 2;
        }
        return round($star_week,2);
    }
}
