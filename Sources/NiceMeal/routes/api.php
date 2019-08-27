<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\User\Checkout\CheckoutController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// API
Route::group(['middleware' => ['checkHeader']],function (){
    //login api
    Route::post('/login','Api\Auth\AuthController@login');
    //signup api
    Route::post('/register', 'Api\Auth\AuthController@signup');

    //google login api
    Route::post('/gg-authenticate','Api\Auth\AuthController@googleAuthenticate');
    //facebook login api
    Route::post('/fb-authenticate','Api\Auth\AuthController@facebookAuthenticate');
    Route::get('/provinces-and-districts','Api\User\HomeController@getProvinceAndDistrict');

    //get districts info api
    Route::get('/districts', 'Api\User\HomeController@getWardsAndDistricts');

    Route::get('/get-filter-list','Api\User\Restaurant\LocationController@getFilterList');

    Route::get('/get-restaurant-info','Api\User\Restaurant\RestaurantController@getMenu');

    Route::post('/add-to-cart','Api\User\Cart\CartController@addToCart');
    Route::post('/subtract-from-cart','Api\User\Cart\CartController@subtractFromCart');
    Route::post('/update-cart','Api\User\Cart\CartController@updateCart');

    //get restaurants
    Route::get('/search-restaurants','Api\User\HomeController@searchRestaurant');

    Route::group(['middleware' => 'api', 'prefix' => 'password'], function () {
        Route::post('/create', 'Api\Auth\AuthController@create');
        Route::get('/find/{token}', 'Api\Auth\AuthController@find');
        Route::post('/reset', 'Api\Auth\AuthController@reset');
    });

    //My info api
    Route::group(['middleware' => ['auth:api']],function(){
        Route::post('/logout','Api\Auth\AuthController@logout');
        Route::get('/my-contact-info','Api\User\MyInfo\InfoController@myInfo');
        Route::post('/update-my-contact-info/{info}','Api\User\MyInfo\InfoController@updateInfo');
        Route::post('/update-main-contact-info','Api\User\MyInfo\InfoController@updateMainInfo');
        Route::post('/delete-my-contact-info/{info}','Api\User\MyInfo\InfoController@deleteInfo');
        Route::post('/create-my-contact-info','Api\User\MyInfo\InfoController@addInfo');



        Route::post('/reorder','Api\User\MyInfo\OrderHistoryController@reOrder');

        Route::get('/my-order-histories','Api\User\MyInfo\OrderHistoryController@myHistories');

        Route::get('/verify-login','Api\Auth\AuthController@verify');
        //change password api
        Route::post('change-password','Api\Auth\AuthController@changePassword');
    });

    //confirm otp api
    Route::post('/confirm-otp','Api\User\Checkout\CheckoutController@confirmotp');

    Route::post('/check-voucher','Api\User\Checkout\CheckoutController@checkVoucher');
    Route::post('/checkout','Api\User\Checkout\CheckoutController@finishOrder');

    //resend otp
    Route::post('/resend-otp','Api\User\Checkout\CheckoutController@resendOtp');

    //payment
    Route::post('/save-payment-info','Api\User\Checkout\CheckoutController@savePaymentInfo');

    //polling order api
    Route::get('/order/polling-order', 'Api\OrdersController@pollingOrder');
    Route::get('/order/order-callback', 'Api\OrdersController@orderCallback');

    //alepay
    Route::post('/encrypt-data','Api\PaymentController@encryptData');
    Route::post('/decrypt-data','Api\PaymentController@decryptData');
});
