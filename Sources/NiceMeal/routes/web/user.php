<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('/sign-out', 'User\\HomesController@getSignOut');

// auth
//Auth::routes();
// Login
Route::post('/login','Auth\\LoginController@newLogin')->name('login');
// Registration Routes...
Route::post('/register','Auth\\RegisterController@newRegister')->name('register');

Route::post('logout','Auth\\LoginController@logout')->name('logout');

Route::get('/mealrest','User\\HomeController@mealRest');
Route::get('/auth/{provider}', 'Auth\\LoginController@redirectToProvider');
Route::get('/auth/{provide}/callback', 'Auth\\LoginController@handleProviderCallback');
Route::get('/auth/verify/{code}', 'Auth\\RegisterController@verify');

//active account
Route::post('/active-account/{account_token}','User\\CheckoutController@activeAccount');
//reset password
Route::get('/password/forgot-password','Auth\\ForgotPasswordController@resetPage');
Route::post('/password/create', 'Auth\\ForgotPasswordController@create');
Route::get('/password/find/{token}', 'Auth\\ForgotPasswordController@find');
Route::post('/password/reset', 'Auth\\ResetPasswordController@reset');

// home
Route::post('/email-marketing', 'User\\HomeController@emailMarketing');
 //User Contact
 Route::get('/contact', 'User\\ContactController@index');
 Route::post('/contact/submit-restaurant', 'User\\ContactController@submitRestaurant');

// locations
Route::post('/locations/{slug}/more', 'User\\LocationsController@loadMore');
Route::post('/locations/{slug}/restaurants/{ward_id?}', 'User\\LocationsController@restaurants');
Route::post('/locations/{slug}/search-restaurants', 'User\\LocationsController@getRestaurants');
Route::get('/locations/{province_id}/districts', 'User\\LocationsController@districts');
Route::get('/locations/{district_id}/wards', 'User\\LocationsController@wards');
Route::get('/locations/all-locations', 'User\\LocationsController@allLocations');

Route::post('/dishes/checkDish','User\\RestaurantsController@dishChange');

// Contact us
Route::get('/contact-us', 'Admin\\ContactController@index_user');
Route::post('/contact-insert', 'Admin\\ContactController@store')->name('contact-insert');

// restaurants
Route::post('/cart/addToCart', 'User\\CartController@addToCart');
Route::post('/cart/saveCart', 'User\\CartController@saveCart');
Route::post('/cart/subtractFromCart/{index}', 'User\\CartController@subtractFromCart');
Route::post('/cart/dishAmountChange/{index}', 'User\\CartController@dishAmountChange');
Route::get('/cart/CheckSession', 'User\\CartController@CheckSession');
Route::get('/cart/clearSession', 'User\\CartController@clearSession');
Route::post('/cart/reOrder', 'User\\CartController@reOrder');
Route::post('/cart/synchonize', 'User\\CartController@Synchonize');

Route::get('reviews/{restaurant_slug}/confirmReview/{id}','Admin\\ReviewsController@confirmReview');
Route::get('reviews/{restaurant_slug}/sendProblemSolved/{id}','Admin\\ReviewsController@sendProblemSolved');
//Route::get('reviews/{restaurant_slug}/approvedProblemSolved/{id}','Admin\\ReviewsController@approvedProblemSolved');

// For admin: problem solve approved in email
Route::get('reviews/approve-solved/{id}','Admin\\ReviewsController@approvedProblemSolved');
// send problem solve mail to customer in email
Route::get('reviews/send-problem-solved/{problem_solve_token}','User\\ReviewsController@sendProblemSolveMail');
// confirm review in email
Route::get('reviews/confirm-review/{confirm_token}','User\\ReviewsController@confirmReview');
//// For end user: problem solve approve in email
//Route::get('reviews/approve-solved/{id}','User\\ReviewsController@approvedProblemSolved');


Route::post('/payment/process-payment', 'PaymentController@processPayment');// route for check status of the payment
Route::get('/payment/payment-status', 'PaymentController@getPaymentStatus');
Route::get('/payment/process-payment-result', 'PaymentController@processPaymentResult');
Route::post('/confirm-online-payment-otp', 'PaymentController@confirmOnlinePaymentOtp');
Route::post('/resend-online-payment-otp', 'PaymentController@resendOnlinePaymentOTP');

Route::group(['middleware'=>['checkCart']],function (){
    // checkout
    Route::post('/finish-check-out', 'User\\CheckoutController@finish');
    Route::post('/confirm-otp', 'User\\CheckoutController@confirmotp');
    Route::post('/resend-otp', 'User\\CheckoutController@resendOTP');
    Route::post('/check-voucher', 'User\\CheckoutController@checkVoucher');
    Route::get('/', 'User\\HomeController@index');
    Route::get('/home', 'User\\HomeController@index');
    Route::get('/locations/{slug}', [
        'as'    => 'locations.show',
        'uses'  => 'User\\LocationsController@show'
    ]);
    Route::post('/restaurants/getCart', 'User\\RestaurantsController@getCart');
    Route::group(['middleware'=>['checkLocation']],function(){
        Route::get('/restaurants/{slug}', 'User\\RestaurantsController@show');
        Route::get('/checkout', 'User\\CheckoutController@index');
    });
    Route::get('/restaurants/{slug}/info', 'User\\RestaurantsController@restaurantInfo');
    Route::get('/restaurants/{slug}/promotion', 'User\\RestaurantsController@getPromotions');
    Route::get('/restaurants/{slug}/intro', 'User\\RestaurantsController@getIntro');

    Route::get('/restaurants/{slug}/reviews', 'User\\ReviewsController@index');
    Route::post('/restaurants/{slug}/reviews-paging', 'User\\ReviewsController@getReviewListByRestaurantPaging');
    Route::get('/reviews/order/{token}', 'User\\ReviewsController@order');
    Route::post('/reviews/order/submit', 'User\\ReviewsController@store');
    Route::get('/languages/{locale}', 'User\\HomeController@changeLocalization');

    // User
    Route::get('my-info','User\\UserController@index');
    Route::post('my-info/update/{id}','User\\UserController@updateProfile');
    Route::post('my-info/add-profile','User\\UserController@addAlterProfile');
    Route::post('my-info/delete-profile/{id}','User\\UserController@deleteAlterProfile');
    Route::post('my-info/update-alter-profile/{id}','User\\UserController@updateAlterProfile');
    Route::get('order-history','User\\UserController@orderHistoryIndex');

    Route::get('/get-wards', 'User\\HomeController@getWardsByDistrictSlug');

});

Route::group(['middleware' => ['translate','permission']], function () {

    Route::get('admin/get-wards', 'Admin\\RestaurantDeliverySettingsController@getWardsByDistrictId');
    // Admin dashboard
    Route::get('admin', 'Admin\\AdminsController@index');
    // Manage admin profile
    Route::get('admin/my-profile', 'Admin\\UsersController@myProfile');
    Route::patch('admin/my-profile', 'Admin\\UsersController@updateProfile');

    // Translation
    Route::get('admin/languages/{language}', 'Admin\\AdminsController@changeLocalization');

    // Manage users
    Route::resource('admin/users', 'Admin\\UsersController', ['except' => ['create', 'store', 'edit', 'destroy']]);
    Route::get('admin/foodie', 'Admin\\UsersController@foodie');

    // uploads
    Route::resource('admin/{restaurant_slug}/uploads', 'Admin\\UploadsController');

    // Manage Restaurants Categories
    Route::resource('admin/restaurants-categories', 'Admin\\RestaurantsCategoriesController',['except' => ['show']]);

    //Cuisines
    Route::resource('admin/cuisines', 'Admin\\CuisinesController');

    //Dishes category of by restaurant_id
    Route::get('admin/{restaurant_slug}/restaurants/categories/{'."App\Http\Controllers\Admin\RestaurantsController"::default_index.'}','Admin\\RestaurantsController@getCategories');

    // Contact
    Route::resource('admin/contacts', 'Admin\\ContactController');
    Route::get('admin/contacts/download/{id}','Admin\\ContactController@download');

    // restaurant
    Route::get('admin/restaurants/import','Admin\\RestaurantsController@import');
    Route::post('admin/restaurants/import','Admin\\RestaurantsController@importPost');
    Route::get('admin/top', 'Admin\\RestaurantsController@top');
    Route::post('admin/update-top', 'Admin\\RestaurantsController@updateTop');
    Route::get('admin/restaurants/chooseRestaurant','Admin\\RestaurantsController@chooseRestaurant');
    Route::post('admin/restaurants/doChooseRestaurant/{restaurant_id}','Admin\\RestaurantsController@doChooseRestaurant');
    Route::resource('admin/restaurants', 'Admin\\RestaurantsController');
    Route::post('admin/restaurants/duplicate/{id}', 'Admin\\RestaurantsController@duplicateRestaurant');
    Route::post('admin/restaurants/changeStatusRestaurant', 'Admin\\RestaurantsController@changeStatusRestaurant');
    Route::post('admin/restaurants/upload', 'Admin\\RestaurantsController@upload');
    Route::post('admin/clear-session','Admin\\AdminsController@clearSession');


    // confirm order link
    Route::get('/confirm-order/{token}','Admin\\OrdersController@showConfirmOrderByEmail');
    Route::post('/change-to-accept/{token}','Admin\\OrdersController@changeToAccept');
    // reject order link
    Route::get('/reject-order/{token}','Admin\\OrdersController@showRejectOrderByEmail');
    Route::post('/change-to-reject/{token}','Admin\\OrdersController@changeToReject');
    // printers
    Route::resource('/admin/printers', 'Admin\\PrintersController');
    Route::get('admin/printers/{'."App\Http\Controllers\Admin\PrintersController"::default_index.'}/export', 'Admin\\PrintersController@export');
    Route::post('admin/printers/duplicate/{'."App\Http\Controllers\Admin\PrintersController"::default_index.'}','Admin\\PrintersController@duplicatePrinters');
    // vouchers
    Route::resource('admin/vouchers', 'Admin\\PromotionsController');
    Route::post('admin/vouchers/duplicate/{'."App\Http\Controllers\Admin\PromotionsController"::default_index.'}','Admin\\PromotionsController@duplicatePromotions');

     //Orders Management for admin
    Route::post('admin/orders/updateAdminNote','Admin\\OrdersController@updateAdminNote');
    Route::post('admin/orders/changeStatus','Admin\\OrdersController@changeStatus');
    Route::post('admin/orders/confirmOrder','Admin\\OrdersController@confirmOrder');
    Route::post('admin/orders/confirmSendSMS','Admin\\OrdersController@confirmSendSMS');
    Route::post('admin/orders/confirmSendMail','Admin\\OrdersController@confirmSendMail');
    Route::get('admin/live', 'Admin\\OrdersController@live');
    Route::get('admin/get-orders','Admin\\OrdersController@getOrders');
    Route::post('admin/orders/confirmResendOrder','Admin\\OrdersController@confirmResendOrder');
    Route::resource('admin/orders', 'Admin\\OrdersController');

    Route::group(['middleware'=>['chooseRestaurant']],function(){
        //dishes
        Route::get('admin/{restaurant_slug}/dishes/dishCustomizations/{'."App\Http\Controllers\Admin\DishesController"::default_index.'}','Admin\\DishesController@dishCustomizations');
        Route::get('admin/{restaurant_slug}/dishes/dishTBDs/{'."App\Http\Controllers\Admin\DishesController"::default_index.'}','Admin\\DishesController@dishTBDs');
        Route::get('admin/{restaurant_slug}/dishes/dishTBPs/{'."App\Http\Controllers\Admin\DishesController"::default_index.'}','Admin\\DishesController@dishTBPs');
        Route::resource('admin/{restaurant_slug}/dishes','Admin\\DishesController');
        Route::post('admin/{restaurant_slug}/dishes/duplicate/{'."App\Http\Controllers\Admin\DishesController"::default_index.'}','Admin\\DishesController@duplicateDishes');
        Route::post('admin/{restaurant_slug}/dishes/changeStatusDish','Admin\\DishesController@changeStatusDish');
        Route::post('admin/{restaurant_slug}/dishes/update-sequence', 'Admin\\DishesController@updateSequence');
        //Customization
        Route::get('admin/{restaurant_slug}/customizations/getOptions/{'."App\Http\Controllers\Admin\CustomizationController"::default_index.'}','Admin\\CustomizationController@getOptions');
        Route::get('admin/{restaurant_slug}/customizations/customizationList','Admin\\CustomizationController@getCustomization');
        Route::post('admin/{restaurant_slug}/customizations/changeStatusCustomization','Admin\\CustomizationController@changeStatusCustomization');
        Route::post('admin/{restaurant_slug}/customizations/duplicate/{'."App\Http\Controllers\Admin\CustomizationController"::default_index.'}','Admin\\CustomizationController@duplicateCustomization');
        Route::resource('admin/{restaurant_slug}/customizations', 'Admin\\CustomizationController');

         // Manage Categories
//        Route::post('admin/{restaurant_slug}/categories/batch','Admin\\CategoriesController@batch');
        Route::get('admin/{restaurant_slug}/categories/categoryTBDs/{'."App\Http\Controllers\Admin\CategoriesController"::default_index.'}','Admin\\CategoriesController@categoryTBDs');
        Route::resource('admin/{restaurant_slug}/categories', 'Admin\\CategoriesController',['except' => ['show']]);
        Route::get('admin/{restaurant_slug}/categories/categoryCustomizations/{'."App\Http\Controllers\Admin\CategoriesController"::default_index.'}','Admin\\CategoriesController@categoryCustomizations');
        Route::post('admin/{restaurant_slug}/categories/duplicate/{'."App\Http\Controllers\Admin\CategoriesController"::default_index.'}','Admin\\CategoriesController@duplicateCategories');
        Route::post('admin/{restaurant_slug}/categories/changeStatusCategory','Admin\\CategoriesController@changeStatusCategory');
        Route::post('admin/{restaurant_slug}/categories/upload', 'Admin\\CategoriesController@upload');
        Route::post('admin/{restaurant_slug}/categories/update-sequence', 'Admin\\CategoriesController@updateSequence');


        // Manage Restaurant delivery settings
        Route::resource('admin/{restaurant_slug}/restaurant-delivery-settings','Admin\\RestaurantDeliverySettingsController',['except' => ['show']]);

        //Work time
        Route::resource('admin/{restaurant_slug}/restaurant-work-times', 'Admin\\RestaurantWorkTimesController');

        // uploads
        Route::resource('admin/{restaurant_slug}/uploads', 'Admin\\UploadsController');
        Route::post('admin/{restaurant_slug}/uploads/upload', 'Admin\\UploadsController@upload');
        Route::post('admin/{restaurant_slug}/uploads//upload', 'Admin\\UploadsController@upload');


        // Manage Time base display rule
//        Route::post('admin/{restaurant_slug}/time-base-display-rules/batch','Admin\\TimeBaseRulesController@batch');
        Route::get('admin/{restaurant_slug}/time-base-display-rules/getList', 'Admin\\TimeBaseRulesController@getList');
        Route::post('admin/{restaurant_slug}/time-base-display-rules/duplicate/{'."App\Http\Controllers\Admin\TimeBaseRulesController"::default_index.'}','Admin\\TimeBaseRulesController@duplicateTBD');
        Route::post('admin/{restaurant_slug}/time-base-display-rules/changeStatusTimeBaseDisplay','Admin\\TimeBaseRulesController@changeStatusTimeBaseDisplay');
        Route::resource('admin/{restaurant_slug}/time-base-display-rules', 'Admin\\TimeBaseRulesController',['except' => ['show']]);


        // Manage Time base pricing rule
//        Route::post('admin/{restaurant_slug}/time-base-pricing-rules/batch','Admin\\TimeBasePricingRulesController@batch');
        Route::get('admin/{restaurant_slug}/time-base-pricing-rules/getList', 'Admin\\TimeBasePricingRulesController@getList');
        Route::resource('admin/{restaurant_slug}/time-base-pricing-rules', 'Admin\\TimeBasePricingRulesController',['except' => ['show']]);
        Route::post('admin/{restaurant_slug}/time-base-pricing-rules/duplicate/{'."App\Http\Controllers\Admin\TimeBasePricingRulesController"::default_index.'}','Admin\\TimeBasePricingRulesController@duplicateTBP');
        Route::post('admin/{restaurant_slug}/time-base-pricing-rules/changeStatusTimeBasePrising','Admin\\TimeBasePricingRulesController@changeStatusTimeBasePrising');

        //Cuisines
        Route::resource('admin/{restaurant_slug}/restaurants-cuisines', 'Admin\\RestaurantsCuisinesController');


        //Orders
        Route::post('admin/{restaurant_slug}/orders/updateAdminNote','Admin\\OrdersController@updateAdminNote');
        Route::post('admin/{restaurant_slug}/orders/changeStatus','Admin\\OrdersController@changeStatus');
        Route::post('admin/{restaurant_slug}/orders/confirmOrder','Admin\\OrdersController@confirmOrder');
        Route::post('admin/{restaurant_slug}/orders/confirmSendSMS','Admin\\OrdersController@confirmSendSMS');
        Route::post('admin/{restaurant_slug}/orders/confirmSendMail','Admin\\OrdersController@confirmSendMail');
        Route::get('admin/{restaurant_slug}/live', 'Admin\\OrdersController@live');
        Route::get('admin/{restaurant_slug}/get-orders','Admin\\OrdersController@getOrders');
        Route::post('admin/{restaurant_slug}/orders/confirmResendOrder','Admin\\OrdersController@confirmResendOrder');
        Route::resource('admin/{restaurant_slug}/orders', 'Admin\\OrdersController');

        // Reviews
//        Route::post('admin/{restaurant_slug}/reviews/solveSendMail','Admin\\ReviewsController@solveSendMail');
        // confirm review
        Route::post('admin/{restaurant_slug}/reviews/changeStatus','Admin\\ReviewsController@changeStatus');
        Route::resource('admin/{restaurant_slug}/reviews', 'Admin\\ReviewsController');

        //send problem solve email
        Route::post('admin/{restaurant_slug}/reviews/send-problem-solved/{id}','Admin\\ReviewsController@sendProblemSolveMail');


        //Printers
        Route::resource('admin/{restaurant_slug}/printers', 'Admin\\PrintersController');
        Route::get('admin/{restaurant_slug}/printers/{'."App\Http\Controllers\Admin\PrintersController"::default_index.'}/export', 'Admin\\PrintersController@export');
        Route::post('admin/{restaurant_slug}/printers/duplicate/{'."App\Http\Controllers\Admin\PrintersController"::default_index.'}','Admin\\PrintersController@duplicatePrinters');

        //Promotions
        Route::resource('admin/{restaurant_slug}/promotions', 'Admin\\PromotionsController');
        Route::post('admin/{restaurant_slug}/promotions/duplicate/{'."App\Http\Controllers\Admin\PromotionsController"::default_index.'}','Admin\\PromotionsController@duplicatePromotions');

        //General info
        Route::get('admin/{restaurant_slug}/detail-info','Admin\\RestaurantsController@showDetailInfo');
        Route::patch('admin/{restaurant_slug}/update-detail-info/{'."App\Http\Controllers\Admin\RestaurantsController"::default_index.'}','Admin\\RestaurantsController@updateDetailInfo');

        //Tags in general info
        Route::get('admin/{restaurant_slug}/general-info-tags','Admin\\RestaurantsController@showTagInfo');
        Route::patch('admin/{restaurant_slug}/update-tags/{'."App\Http\Controllers\Admin\RestaurantsController"::default_index.'}','Admin\\RestaurantsController@updateTagInfo');

        // Settings
        Route::get('admin/{restaurant_slug}/exchange-rate','Admin\\RestaurantsController@exchangeRate');
        Route::patch('admin/{restaurant_slug}/update-exchange-rate/{'."App\Http\Controllers\Admin\RestaurantsController"::default_index.'}','Admin\\RestaurantsController@exchangeRateUpdate');

        //Otp setting
        Route::get('admin/{restaurant_slug}/otp-settings','Admin\\RestaurantsController@showOtpSetting');
        Route::patch('admin/{restaurant_slug}/update-otp-setting/{'."App\Http\Controllers\Admin\RestaurantsController"::default_index.'}','Admin\\RestaurantsController@updateOtpSetting');

        //Tax info
        Route::get('admin/{restaurant_slug}/tax-info','Admin\\TaxesController@showTaxInfo');
        Route::patch('admin/{restaurant_slug}/update-tax-info/{'."App\Http\Controllers\Admin\TaxesController"::default_index.'}','Admin\\TaxesController@updateTaxInfo');
        Route::post('admin/{restaurant_slug}/create-tax','Admin\\TaxesController@createTax');

         //Intro
        Route::get('admin/{restaurant_slug}/intro','Admin\\RestaurantsController@showIntro');
        Route::patch('admin/{restaurant_slug}/update-intro/{'."App\Http\Controllers\Admin\RestaurantsController"::default_index.'}','Admin\\RestaurantsController@updateIntro');


        //Sale report
        Route::get('admin/{restaurant_slug}/get-report','Admin\\SaleReportController@getReport');
        Route::get('admin/{restaurant_slug}/sale-report','Admin\\SaleReportController@index');

        //Invoice report
        Route::get('admin/{restaurant_slug}/invoice-report','Admin\\InvoiceReportsController@index');

        //Payment Setting
        Route::get('admin/{restaurant_slug}/payment-settings','Admin\\RestaurantsController@showPaymentSetting');
        Route::patch('admin/{restaurant_slug}/update-payment-setting/{'."App\Http\Controllers\Admin\RestaurantsController"::default_index.'}','Admin\\RestaurantsController@savePaymentSetting');


    });



    //Tags
    Route::resource('admin/tags', 'Admin\\TagController');
    Route::post('admin/tags/duplicate/{'."App\Http\Controllers\Admin\TagController"::default_index.'}','Admin\\TagController@duplicateTag');

    //OrderRejectReason
    Route::resource('admin/order-reject-reason', 'Admin\\OrderRejectReasonController');
    Route::post('admin/order-reject-reason/duplicate/{id}','Admin\\OrderRejectReasonController@duplicateOrderRejectReason');

});
//faqs
Route::get('/restaurants/{slug}/faqs','User\\RestaurantsController@showFaqs');