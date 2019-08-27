<?php


Route::group(['middleware' => ['translate', 'permission']], function () {

    Route::resource('/roles','Admin\\RoleController')->middleware('can:is-admin');

    // Admin dashboard
    Route::get('/', 'Admin\\AdminsController@index');
    // Manage admin profile
    Route::get('/my-profile', 'Admin\\UsersController@myProfile');
    Route::patch('/my-profile', 'Admin\\UsersController@updateProfile');

    // Translation
    Route::get('/languages/{language}', 'Admin\\AdminsController@changeLocalization');

    // Manage users
    Route::resource('/users', 'Admin\\UsersController', ['except' => ['create', 'store', 'edit', 'destroy']])->middleware('can:is-admin-or-manage-all-restaurant');
    Route::get('/foodie', 'Admin\\UsersController@foodie');

    // uploads
    Route::resource('/{restaurant_slug}/uploads', 'Admin\\UploadsController');

    // Manage Restaurants Categories
    Route::resource('/restaurants-categories', 'Admin\\RestaurantsCategoriesController',['except' => ['show']]);

    //Cuisines
    Route::resource('/cuisines', 'Admin\\CuisinesController');

    //Dishes category of by restaurant_id
    Route::get('/{restaurant_slug}/restaurants/categories/{'."App\Http\Controllers\Admin\RestaurantsController"::default_index.'}','Admin\\RestaurantsController@getCategories');

    // Contact
    Route::resource('/contacts', 'Admin\\ContactController');
    Route::get('/contacts/download/{id}','Admin\\ContactController@download');
    // Faqs
    Route::resource('/faqs', 'Admin\\FaqsController');
    Route::resource('/faqs-type', 'Admin\\FaqsTypeController');
    
    // restaurant
    Route::get('/restaurants/import','Admin\\RestaurantsController@import');
    Route::post('/restaurants/import','Admin\\RestaurantsController@importPost');
    Route::get('/top', 'Admin\\RestaurantsController@top');
    Route::post('/update-top', 'Admin\\RestaurantsController@updateTop');
    Route::get('/restaurants/chooseRestaurant','Admin\\RestaurantsController@chooseRestaurant');
    Route::post('/restaurants/doChooseRestaurant/{restaurant_id}','Admin\\RestaurantsController@doChooseRestaurant');
    Route::resource('/restaurants', 'Admin\\RestaurantsController');
    Route::post('/restaurants/duplicate/{id}', 'Admin\\RestaurantsController@duplicateRestaurant');
    Route::post('/{restaurant_slug}/restaurants/changeStatusRestaurant','Admin\\RestaurantsController@changeStatus');
    Route::post('/restaurants/changeStatusRestaurant','Admin\\RestaurantsController@changeStatusRestaurant');
    Route::post('/restaurants/upload', 'Admin\\RestaurantsController@upload');
    Route::post('/clear-session','Admin\\AdminsController@clearSession');
    Route::post('/{restaurant_slug}/restaurants/update-sequence', 'Admin\\RestaurantsController@updateSequence');


    // confirm order link
    Route::get('/confirm-order/{token}','Admin\\OrdersController@showConfirmOrderByEmail');
    Route::post('/change-to-accept/{token}','Admin\\OrdersController@changeToAccept');
    // reject order link
    Route::get('/reject-order/{token}','Admin\\OrdersController@showRejectOrderByEmail');
    Route::post('/change-to-reject/{token}','Admin\\OrdersController@changeToReject');
    // printers
    Route::resource('/printers', 'Admin\\PrintersController');
    Route::get('/printers/{'."App\Http\Controllers\Admin\PrintersController"::default_index.'}/export', 'Admin\\PrintersController@export');
    Route::post('/printers/duplicate/{'."App\Http\Controllers\Admin\PrintersController"::default_index.'}','Admin\\PrintersController@duplicatePrinters');
    // vouchers
    Route::resource('/vouchers', 'Admin\\PromotionsController');
    Route::post('/vouchers/duplicate/{'."App\Http\Controllers\Admin\PromotionsController"::default_index.'}','Admin\\PromotionsController@duplicatePromotions');

     //Orders Management for admin
    Route::post('/orders/updateAdminNote','Admin\\OrdersController@updateAdminNote');
    Route::post('/orders/changeStatus','Admin\\OrdersController@changeStatus');
    Route::post('/orders/confirmOrder','Admin\\OrdersController@confirmOrder');
    Route::post('/orders/confirmSendSMS','Admin\\OrdersController@confirmSendSMS');
    Route::post('/orders/confirmSendMail','Admin\\OrdersController@confirmSendMail');
    Route::get('/live', 'Admin\\OrdersController@live');
    Route::get('/get-orders','Admin\\OrdersController@getOrders');
    Route::post('/orders/confirmResendOrder','Admin\\OrdersController@confirmResendOrder');
    Route::resource('/orders', 'Admin\\OrdersController');

    Route::group(['middleware'=>['chooseRestaurant']],function(){
        //dishes
        Route::get('/{restaurant_slug}/dishes/dishCustomizations/{'."App\Http\Controllers\Admin\DishesController"::default_index.'}','Admin\\DishesController@dishCustomizations');
        Route::get('/{restaurant_slug}/dishes/dishTBDs/{'."App\Http\Controllers\Admin\DishesController"::default_index.'}','Admin\\DishesController@dishTBDs');
        Route::get('/{restaurant_slug}/dishes/dishTBPs/{'."App\Http\Controllers\Admin\DishesController"::default_index.'}','Admin\\DishesController@dishTBPs');
        Route::resource('/{restaurant_slug}/dishes','Admin\\DishesController');
        Route::post('/{restaurant_slug}/dishes/duplicate/{'."App\Http\Controllers\Admin\DishesController"::default_index.'}','Admin\\DishesController@duplicateDishes');
        Route::post('/{restaurant_slug}/dishes/changeStatusDish','Admin\\DishesController@changeStatusDish');
        Route::post('/{restaurant_slug}/dishes/update-sequence', 'Admin\\DishesController@updateSequence');
        //Customization
        Route::get('/{restaurant_slug}/customizations/getOptions/{'."App\Http\Controllers\Admin\CustomizationController"::default_index.'}','Admin\\CustomizationController@getOptions');
        Route::get('/{restaurant_slug}/customizations/customizationList','Admin\\CustomizationController@getCustomization');
        Route::post('/{restaurant_slug}/customizations/changeStatusCustomization','Admin\\CustomizationController@changeStatusCustomization');
        Route::resource('/{restaurant_slug}/customizations', 'Admin\\CustomizationController');

         // Manage Categories
//        Route::post('/{restaurant_slug}/categories/batch','Admin\\CategoriesController@batch');
        Route::get('/{restaurant_slug}/categories/categoryTBDs/{'."App\Http\Controllers\Admin\CategoriesController"::default_index.'}','Admin\\CategoriesController@categoryTBDs');
        Route::resource('/{restaurant_slug}/categories', 'Admin\\CategoriesController',['except' => ['show']]);
        Route::get('/{restaurant_slug}/categories/categoryCustomizations/{'."App\Http\Controllers\Admin\CategoriesController"::default_index.'}','Admin\\CategoriesController@categoryCustomizations');
        Route::post('/{restaurant_slug}/categories/duplicate/{'."App\Http\Controllers\Admin\CategoriesController"::default_index.'}','Admin\\CategoriesController@duplicateCategories');
        Route::post('/{restaurant_slug}/categories/changeStatusCategory','Admin\\CategoriesController@changeStatusCategory');
        Route::post('/{restaurant_slug}/categories/upload', 'Admin\\CategoriesController@upload');
        Route::post('/{restaurant_slug}/categories/update-sequence', 'Admin\\CategoriesController@updateSequence');


        // Manage Restaurant delivery settings
        Route::resource('/{restaurant_slug}/restaurant-delivery-settings','Admin\\RestaurantDeliverySettingsController',['except' => ['show']]);

        //Work time
        Route::resource('/{restaurant_slug}/restaurant-work-times', 'Admin\\RestaurantWorkTimesController');

        // uploads
        Route::resource('/{restaurant_slug}/uploads', 'Admin\\UploadsController');
        Route::post('/{restaurant_slug}/uploads/upload', 'Admin\\UploadsController@upload');
        Route::post('/{restaurant_slug}/uploads//upload', 'Admin\\UploadsController@upload');


        // Manage Time base display 
//        Route::post('/{restaurant_slug}/time-base-display-rules/batch','Admin\\TimeBaseRulesController@batch');
        Route::get('/{restaurant_slug}/time-base-display-rules/getList', 'Admin\\TimeBaseRulesController@getList');
        Route::post('/{restaurant_slug}/time-base-display-rules/duplicate/{'."App\Http\Controllers\Admin\TimeBaseRulesController"::default_index.'}','Admin\\TimeBaseRulesController@duplicateTBD');
        Route::post('/{restaurant_slug}/time-base-display-rules/changeStatusTimeBaseDisplay','Admin\\TimeBaseRulesController@changeStatusTimeBaseDisplay');
        Route::resource('/{restaurant_slug}/time-base-display-rules', 'Admin\\TimeBaseRulesController',['except' => ['show']]);


        // Manage Time base pricing rule
//        Route::post('/{restaurant_slug}/time-base-pricing-rules/batch','Admin\\TimeBasePricingRulesController@batch');
        Route::get('/{restaurant_slug}/time-base-pricing-rules/getList', 'Admin\\TimeBasePricingRulesController@getList');
        Route::resource('/{restaurant_slug}/time-base-pricing-rules', 'Admin\\TimeBasePricingRulesController',['except' => ['show']]);
        Route::post('/{restaurant_slug}/time-base-pricing-rules/duplicate/{'."App\Http\Controllers\Admin\TimeBasePricingRulesController"::default_index.'}','Admin\\TimeBasePricingRulesController@duplicateTBP');
        Route::post('/{restaurant_slug}/time-base-pricing-rules/changeStatusTimeBasePrising','Admin\\TimeBasePricingRulesController@changeStatusTimeBasePrising');

        //Cuisines
        Route::resource('/{restaurant_slug}/restaurants-cuisines', 'Admin\\RestaurantsCuisinesController');

        //Orders
        Route::post('/{restaurant_slug}/orders/updateAdminNote','Admin\\OrdersController@updateAdminNote');
        Route::post('/{restaurant_slug}/orders/changeStatus','Admin\\OrdersController@changeStatus');
        Route::post('/{restaurant_slug}/orders/confirmOrder','Admin\\OrdersController@confirmOrder');
        Route::post('/{restaurant_slug}/orders/confirmSendSMS','Admin\\OrdersController@confirmSendSMS');
        Route::post('/{restaurant_slug}/orders/confirmSendMail','Admin\\OrdersController@confirmSendMail');
        Route::get('/{restaurant_slug}/live', 'Admin\\OrdersController@live');
        Route::get('/{restaurant_slug}/get-orders','Admin\\OrdersController@getOrders');
        Route::post('/{restaurant_slug}/orders/confirmResendOrder','Admin\\OrdersController@confirmResendOrder');
        Route::resource('/{restaurant_slug}/orders', 'Admin\\OrdersController');

        // Reviews
//        Route::post('admin/{restaurant_slug}/reviews/solveSendMail','Admin\\ReviewsController@solveSendMail');
        // confirm review
        Route::post('/{restaurant_slug}/reviews/changeStatus','Admin\\ReviewsController@changeStatus');
        Route::resource('/{restaurant_slug}/reviews', 'Admin\\ReviewsController');

        //send problem solve email
        Route::post('/{restaurant_slug}/reviews/send-problem-solved/{id}','Admin\\ReviewsController@sendProblemSolveMail');


        //Printers
        Route::resource('/{restaurant_slug}/printers', 'Admin\\PrintersController');
        Route::get('/{restaurant_slug}/printers/{'."App\Http\Controllers\Admin\PrintersController"::default_index.'}/export', 'Admin\\PrintersController@export');
        Route::post('/{restaurant_slug}/printers/duplicate/{'."App\Http\Controllers\Admin\PrintersController"::default_index.'}','Admin\\PrintersController@duplicatePrinters');

        //Promotions
        Route::resource('/{restaurant_slug}/promotions', 'Admin\\PromotionsController');
        Route::post('/{restaurant_slug}/promotions/duplicate/{'."App\Http\Controllers\Admin\PromotionsController"::default_index.'}','Admin\\PromotionsController@duplicatePromotions');

        //General info
        Route::get('/{restaurant_slug}/detail-info','Admin\\RestaurantsController@showDetailInfo');
        Route::patch('/{restaurant_slug}/update-detail-info/{'."App\Http\Controllers\Admin\RestaurantsController"::default_index.'}','Admin\\RestaurantsController@updateDetailInfo');

        //Tags in general info
        Route::get('/{restaurant_slug}/general-info-tags','Admin\\RestaurantsController@showTagInfo');
        Route::patch('/{restaurant_slug}/update-tags/{'."App\Http\Controllers\Admin\RestaurantsController"::default_index.'}','Admin\\RestaurantsController@updateTagInfo');

        // Settings
        Route::get('/{restaurant_slug}/exchange-rate','Admin\\RestaurantsController@exchangeRate');
        Route::patch('/{restaurant_slug}/update-exchange-rate/{'."App\Http\Controllers\Admin\RestaurantsController"::default_index.'}','Admin\\RestaurantsController@exchangeRateUpdate');

        //Otp setting
        Route::get('/{restaurant_slug}/otp-settings','Admin\\RestaurantsController@showOtpSetting');
        Route::patch('/{restaurant_slug}/update-otp-setting/{'."App\Http\Controllers\Admin\RestaurantsController"::default_index.'}','Admin\\RestaurantsController@updateOtpSetting');

        //Tax info
        Route::get('/{restaurant_slug}/tax-info','Admin\\TaxesController@showTaxInfo');
        Route::patch('/{restaurant_slug}/update-tax-info/{'."App\Http\Controllers\Admin\TaxesController"::default_index.'}','Admin\\TaxesController@updateTaxInfo');
        Route::post('/{restaurant_slug}/create-tax','Admin\\TaxesController@createTax');

         //Intro
        Route::get('/{restaurant_slug}/intro','Admin\\RestaurantsController@showIntro');
        Route::patch('/{restaurant_slug}/update-intro/{'."App\Http\Controllers\Admin\RestaurantsController"::default_index.'}','Admin\\RestaurantsController@updateIntro');


        //Sale report
        Route::get('/{restaurant_slug}/get-report','Admin\\SaleReportController@getReport');
        Route::get('/{restaurant_slug}/sale-report','Admin\\SaleReportController@index');

        //Invoice report
        Route::get('/{restaurant_slug}/invoice-report','Admin\\InvoiceReportsController@index');

        Route::resource('/{restaurant_slug}/commission-rules', 'Admin\\CommissionRulesController');
    });

    //Tags
    Route::resource('/tags', 'Admin\\TagController');
    Route::post('/tags/duplicate/{'."App\Http\Controllers\Admin\TagController"::default_index.'}','Admin\\TagController@duplicateTag');

    //OrderRejectReason
    Route::resource('/order-reject-reason', 'Admin\\OrderRejectReasonController');
    Route::post('/order-reject-reason/duplicate/{id}','Admin\\OrderRejectReasonController@duplicateOrderRejectReason');

    // Commission Rules
    Route::resource('/commission-rules', 'Admin\\CommissionRulesController');

    //Location
    Route::get('/location/district','Admin\\LocationController@index');
    Route::post('/location/district/update-sequence-district', 'Admin\\LocationController@updateSequenceDistrict');
    Route::get('/location/ward','Admin\\LocationController@showDistrict');
    Route::post('/location/ward/search','Admin\\LocationController@searchWardByDistrict');   
    Route::post('/location/ward/update-sequence-ward', 'Admin\\LocationController@updateSequenceWard'); 
});
Route::post('/image-list/upload',function(){
    return;
});
Route::get('/image-list/get','Admin\\ImageUploadController@getImageList');
Route::post('/upload-image','Admin\\ImageUploadController@uploadImage');