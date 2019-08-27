<?php

namespace App\Http\Controllers\User;

use App\Mail\ProblemSolvedMail;
use App\Models\Review;
use App\Mail\ReviewReceivedMail;
use App\Models\Order;
use App\Models\ReviewToken;
use App\Models\User;
use App\Models\Ward;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\OrderCustomerInfo;
use Session,DB;
use App\Services\RestaurantService;
use App\Services\ReviewService;


class ReviewsController extends Controller
{
    public function index($slug, Request $request) {
        $cart = Session::get('cart');
        $lang = Session::get('locale');
        $restaurant = RestaurantService::getRestaurantFromRequest($request,$slug,$lang);

        if($restaurant == null){
            Session::flash("flash_error","No delivery available");
            return redirect('/');
        }
        $categories = RestaurantService::getRestaurantCategories($restaurant->id,$lang)[0];
        $orderServices = collect($restaurant->orderServices());
        $orderPayments = collect($restaurant->orderPayments());


        //
        $token = '';
        $showCountDown = false;
        $expired = false;
        $counDownValue = 0;
        $reviewer = '';
        $today = new Carbon();

        if($request->query->has('token')) {
            $token = $request->query->get('token');
            $review_token ='';
            // check token exist
            try {
                $review_token = ReviewToken::where('token',$token)->firstOrFail(); // return page 404 when not exist
            } catch (\Exception $exception) {
                $expired = true;
                Session::flash('flash_error', trans('b2c.reviews.token_invalid'));
            }
            $review_order_comfirm = $today;
            if(isset($review_token->created_at)) {
                $review_order = Order::where('id',$review_token->order_id)->firstOrFail(); 
                $review_order_comfirm = Carbon::parse($review_order->confirm_delivery_time);
            }
            // check token valid time
            $valid_time = isset($review_token->created_at)?$review_token->created_at:$today;

            if($valid_time<$today && !empty($review_token)){
                if($review_order_comfirm > $today) {
                    $showCountDown = true;
                }
                //getting time difference in seconds.
                $today_c  =Carbon::parse($today);
                $review_order_comfirm_c = Carbon::parse($review_order_comfirm);
                $counDownValue = $review_order_comfirm_c->diffInSeconds($today_c);
                // check token expire
                $expired_at = $review_token->created_at;
                $expired_at->addHours(24);
                if($expired_at < $today) {
                    Session::flash('flash_error', trans('b2c.reviews.token_expired'));
                   //$review_token->delete();
                    $expired = true;
                }
                $reviewer = OrderCustomerInfo::where('order_id',$review_token->order_id)->select("full_name")->first();
            }

        }

        $reviews = ReviewService::getPublishedReviews_Single_Restaurant($restaurant)->offset(0)->limit(5)->get();
        return view('user.restaurants.review', compact('today','reviewer','expired','counDownValue',
        'showCountDown', 'slug', 'restaurant', 'categories',
         'cart', 'orderServices', 'orderPayments','reviews','token'));
    }

    public function order($token) {
        // check token exist
        $review_token = ReviewToken::where('token',$token)->firstOrFail(); // return page 404 when not exist
        $today = new Carbon();
        // check token valid time
        $valid_time = $review_token->created_at;
        $valid_time->addHours(2);
        if($valid_time > $today) {
            Session::flash('flash_error', trans('user.reviews.token.invalid'));
            return redirect('/');
        }

        // check token expire
        $expired_at = $review_token->created_at;
        $expired_at->addHours(24);
        if($expired_at < $today) {
            Session::flash('flash_error', trans('user.reviews.token.expired'));
            $review_token->delete();
            return redirect('/');
        }

        $order = Order::findOrFail($review_token->order_id);
        return view('user.reviews.order',compact('order','token'));
    }

    public function store(Request $request) {
        $requestData = $request->all();
        $resultData = array(
            'is_success' => false,
            'message' => ''
        );

        // check token
        $token = $requestData['token'];

        // try catch return json not exist
        try {
            $review_token =  ReviewToken::where('token',$token)->firstOrFail();
        } catch (\Exception $exception) {
            $resultData['message'] = 'token not exist';
            return response()->json($resultData);
        }
        // get order info
        try {
            $order = Order::findOrFail($review_token->order_id);
        } catch (\Exception $exception) {
            $resultData['message'] = 'order not exist';
            return response()->json($resultData);
        }
        $insertData = array();
        $insertData['order_id'] = $review_token['order_id'];
        $insertData['customer_id'] = $order['user_id'];
        $insertData['restaurant_id'] = $order['restaurant_id'];
        $insertData['food_rate'] = $requestData['ratingFood'];
        $insertData['service_rate'] = $requestData['ratingService'];
        $insertData['comment'] = $requestData['commentReview'];
        $carbon = new Carbon();
        $insertData['created_at'] = $carbon;
        $insertData['updated_at'] = $carbon;
        $insertData['confirm_token'] = str_random(32);
        $insertData['problem_solve_token'] = str_random(32);

        try {
            Review::insert($insertData);
            $userData = User::where('id', $order['user_id'])->first();
            $orderData = Order::where('id',$review_token['order_id'])->first();
            $resData = Restaurant::where('id',$order['restaurant_id'])->first();
            \Mail::to($resData->email)->send(new ReviewReceivedMail($userData,$orderData,$resData));

        } catch (\Exception $exception) {
            $resultData['message'] = $exception->getMessage();
            return response()->json($resultData);
        }
        // remove review token
        $review_token->delete();

        $resultData['is_success'] = true;
        return response()->json($resultData);
    }

    public function confirmReview($confirm_token)
    {
        $review = Review::where('confirm_token',$confirm_token)->first();
        if(empty($review)){
            Session::flash('flash_error', "Review is not exist");
            return redirect('/');
        }
        if($review->status >= 2){
            Session::flash('flash_error', 'This review has been solved or confirmed, no action required');
            return redirect('/');
        }
        $review->status = 2;
        $review->published = true;
        $review->save();

        Session::flash('flash_message', 'Review has been confirmed');
        return redirect('/');

    }

    public function sendProblemSolveMail($problem_solve_token)
    {
        $review = Review::where('problem_solve_token',$problem_solve_token)->first();
        \Log::info($review);
        if(empty($review)){
            Session::flash('flash_error', "Review is not exist");
            return redirect('/');
        }
        $review->published = false;
        $userEmail = User::where('id',$review->customer_id)->first()->email;
        if (empty($userEmail)){
            Session::flash('flash_error', "User email is not exist");
            return redirect('/');
        }
        $resData = Restaurant::where('id',$review->restaurant_id)->first();
        $review->save();

        \Mail::to($userEmail)->send(new ProblemSolvedMail($resData,$review));
        Session::flash('flash_message', "An email problem solved will be send to customer.");

        return redirect('/');
    }

    public function getReviewListByRestaurantPaging(Request $request) {
        $lang = Session::get('locale');

        $requestData = $request->all();
        $result = ['data' => '', 'message' => '', 'error'=> false];
        $reviews = null;
        if(isset($requestData['offset']) && isset($requestData['slug']) && isset($requestData['district_slug'])) {
            $district_slug = $requestData['district_slug'];
            $restaurant = RestaurantService::getRestaurantInfo([
                'restaurant_slug' => $requestData['slug'],
                'district_slug' => $district_slug,
                'ward_id' => null
            ],$lang);
            $reviews = ReviewService::getPublishedReviews_Single_Restaurant($restaurant)->offset((int)$requestData['offset'] * 5)->limit(5)->get();
        } else {
            $result = ['data' => '', 'message' => 'Error', 'error'=> true];
            return response()->json($result);
        }
        $data = '';
        if(!is_null($reviews)) {
            foreach ($reviews as $review) {
                $data = '<li class="comment"><div class="comment_container"><div class="comment-avatar"><a href="#"><img class="avatar" src="'. url('common-assets/img/profile.jpg') .'" alt=""/></a></div><div class="comment-text"><div class="comment-meta"><span class="author">'. $review->full_name .'</span><span class="date">'. date('d-m-Y h:i:s',$review->created_time) .'</span></div><div class="comment-star"><div class="comment-star-item"><span>Food:</span><div class="rating"><div class="rating__rating" title="'.$review->food_rate.'" count="'.$review->food_rate.'"><span  class="rating__icon" style="width: '.round($review->food_rate / 5 * 100,0).'%;"></span></div></div></div><div class="comment-star-item"><span>Service:</span><div class="rating"><div class="rating__rating" title="'.$review->service_rate.'" count="'.$review->service_rate.'"><span  class="rating__icon" style="width: '.round($review->service_rate / 5 * 100,0).'%;"></span></div></div></div></div><div class="comment-description"><p>'.$review->comment.'</p></div><div class="comment-footer"><span class="comment-note"></span></div></div></div></li>';
            }
            $result = ['data' => $data, 'message' => 'Success', 'error'=> false];
        }
        return response()->json($result);
    }

}
