<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Role extends Model
{
    const PERMISSIONS = [
        'DASHBOARS_VIEW'                        => [
          'code' => 'a1',
          'group' => 'DASHBOARS'
        ],
        'USERS_MANAGE'                          => [
          'code' => 'u2',
          'group' => 'USERS'
        ],
        'USERS_VIEW'                            => [
          'code' => 'u1',
          'group' => 'USERS'
        ],
        'RESTAURANT_VIEW'                       => [
          'code' => 'res1',
          'group' =>  'RESTAURANT'
        ],
        'RESTAURANT_MANAGE'                     => [
          'code' => 'res2',
          'group' =>  'RESTAURANT'
        ],
        'UPLOAD_VIEW'                           => [
          'code' => 'up1',
          'group' =>  'UPLOAD'
        ],
        'UPLOAD_MANAGE'                         => [
          'code' => 'up2',
          'group' =>  'UPLOAD'
        ],
        'DISH_VIEW'                             => [
          'code' => 'd1',
          'group' =>  'DISH'
        ],
        'DISH_MANAGE'                           => [
          'code' => 'd2',
          'group' =>  'DISH'
        ],
        'CATEGORY_VIEW'                         => [
          'code' => 'c1',
          'group' => 'CATEGORY'
        ],
        'CATEGORY_MANAGE'                       => [
          'code' => 'c2',
          'group' => 'CATEGORY'
        ],
        'TIME_BASE_RULE_VIEW'                       => [
          'code' => 'tbr1',
          'group' => 'TIME_BASE_RULE'
        ],
        'TIME_BASE_RULE_MANAGE'                       => [
          'code' => 'tbr2',
          'group' => 'TIME_BASE_RULE'
        ],
        'CUSTOMIZATION_VIEW'                       => [
          'code' => 'cus1',
          'group' => 'CUSTOMIZATION'
        ],
        'CUSTOMIZATION_MANAGE'                       => [
          'code' => 'cus2',
          'group' => 'CUSTOMIZATION'
        ],
        'RESTAURANT_CATEGORY_VIEW'                       => [
          'code' => 'reca1',
          'group' => 'RESTAURANT_CATEGORY'
        ],
        'RESTAURANT_CATEGORY_MANAGE'                       => [
          'code' => 'reca2',
          'group' => 'RESTAURANT_CATEGORY'
        ],
        'RESTAURANT_DELIVERY_SETTING_VIEW'                       => [
          'code' => 'rds1',
          'group' => 'RESTAURANT_DELIVERY_SETTING'
        ],
        'RESTAURANT_DELIVERY_SETTING_MANAGE'                       => [
          'code' => 'rds2',
          'group' => 'RESTAURANT_DELIVERY_SETTING'
        ],
        'RESTAURANT_CUISINES_SETTING_VIEW'                       => [
          'code' => 'recs1',
          'group' => 'RESTAURANT_CUISINES_SETTING'
        ],
        'RESTAURANT_CUISINES_SETTING_MANAGE'                       => [
          'code' => 'recs2',
          'group' => 'RESTAURANT_CUISINES_SETTING'
        ],
        'TIME_BASE_PRICING_RULES_VIEW'                       => [
          'code' => 'tbpr1',
          'group' => 'TIME_BASE_PRICING_RULES'
        ],
        'TIME_BASE_PRICING_RULES_MANAGE'                       => [
          'code' => 'tbpr2',
          'group' => 'TIME_BASE_PRICING_RULES'
        ],
        'TAG_VIEW'                       => [
          'code' => 't1',
          'group' => 'TAG'
        ],
        'TAG_MANAGE'                       => [
          'code' => 't2',
          'group' => 'TAG'
        ],
        'REJECT_REASON_VIEW'                       => [
          'code' => 'rr1',
          'group' => 'REJECT_REASON'
        ],
        'REJECT_REASON_MANAGE'                       => [
          'code' => 'rr2',
          'group' => 'REJECT_REASON'
        ],
        'TAX_VIEW'                       => [
          'code' => 'ta1',
          'group' => 'TAX'
        ],
        'TAX_MANAGE'                       => [
          'code' => 'ta2',
          'group' => 'TAX'
        ],
        'PRINTER_VIEW'                       => [
          'code' => 'p1',
          'group' => 'PRINTER'
        ],
        'PRINTER_MANAGE'                       => [
          'code' => 'p2',
          'group' => 'PRINTER'
        ],
        'PROMOTION_VIEW'                       => [
          'code' => 'pr1',
          'group' => 'PROMOTION'
        ],
        'PROMOTION_MANAGE'                       => [
          'code' => 'pr2',
          'group' => 'PROMOTION'
        ],
    ];

    const CONTROLLERS = [
        'AdminsController' => [
            'index' => ['a1'],
            'show' => ['a1'],
            'edit' => ['a2'],
            'update' => ['a2'],
            'changeLocalization' =>['a1'],
            'clearSession' => ['a2']
        ],
        'UsersController' => [
            'index' => ['u1'],
            'show' => ['u1'],
            'edit' => ['u2'],
            'update' => ['u2'],
            'foodie' => ['u1']
        ],
        'RestaurantsController' => [
            'index' => ['res1'],
            'show' => ['res1'],
            'edit' => ['res2'],
            'update' => ['res2'],
            'store' => ['res2'],
            'create' => ['res2'],
            'destroy' => ['res2'],
            'getCategories'=>['res1'],
            'chooseRestaurant'=>['res1'],
            'doChooseRestaurant'=> ['res2'],
            'duplicateRestaurant'=> ['res2'],
            'changeStatusRestaurant'=> ['res2'],
            'upload' => ['res2'],
            'top' => ['res2'],
            'updateTop' => ['res2'],
            'showDetailInfo' => ['res2'],
            'updateDetailInfo' => ['res2'],
            'showTagInfo' => ['res2'],
            'updateTagInfo' => ['res2'],
            'showOtpSetting' => ['res2'],
            'updateOtpSetting' => ['res2'],
            'exchangeRate' => ['res2'],
            'exchangeRateUpdate' => ['res2'],
            'showIntro' => ['res2'],
            'updateIntro' => ['res2']
        ],
        'UploadsController' => [
            'index' => ['up1'],
            'show' => ['up1'],
            'edit' => ['up2'],
            'update' => ['up2'],
            'store' => ['up2'],
            'create' => ['up2'],
            'destroy' => ['up2'],
            'upload' => ['up2']
        ],
        'DishesController' => [
            'index' => ['res2','d1'],
            'show' => ['res2','d1'],
            'edit' => ['res2','d2'],
            'update' => ['res2','d2'],
            'store' => ['res2','d2'],
            'create' => ['res2','d2'],
            'destroy' => ['res2','d2'],
            'dishCustomizations'=>['res2','d1'],
            'dishTBDs' => ['res2','d1'],
            'dishTBPs' => ['res2','d1'],
            'duplicateDishes' => ['res2','d2'],
            'changeStatusDish' => ['res2','d2'],
            'updateSequence' => ['res2','d2']
        ],
        'CategoriesController' => [
            'index' => ['res2','c1'],
            'show' => ['res2','c1'],
            'edit' => ['res2','c2'],
            'update' => ['res2','c2'],
            'store' => ['res2','c2'],
            'create' => ['res2','c2'],
            'destroy' => ['res2','c2'],
            'categoryTBDs' => ['res2','c1'],
//            'batch' => ['c1'],
            'duplicateCategories' => ['res2','c2'],
            'categoryCustomizations'=>['res2','c1'],
            'changeStatusCategory' => ['res2','c2'],
            'upload' => ['res2','c2'],
            'updateSequence' => ['res2','c2'],
        ],
        'TimeBaseRulesController' => [
            'index' => ['res2','tbr1'],
            'show' => ['res2','tbr1'],
            'edit' => ['res2','tbr2'],
            'update' => ['res2','tbr2'],
            'store' => ['res2','tbr2'],
            'create' => ['res2','tbr2'],
            'destroy' => ['res2','tbr2'],
            'getList'=> ['res2','tbr1'],
//            'batch' => ['tbr1'],
            'duplicateTBD' => ['res2','tbr2'],
            'changeStatusTimeBaseDisplay' => ['res2','tbr2'],
        ],
        'SaleReportController'=>[
            'index' => ['res1'],
            'getReport'=>['res1']
        ],
        'InvoiceReportsController'=>[
            'index' => ['res1'],
        ],
        'CuisinesController' => [
            'index' => ['res1'],
            'show' => ['res1'],
            'edit' => ['res2'],
            'update' => ['res2'],
            'store' => ['res2'],
            'create' => ['res2'],
            'destroy' => ['res2']
        ],
        'RestaurantWorkTimesController' => [
            'index' => ['res1'],
            'show' => ['res1'],
            'edit' => ['res2'],
            'update' => ['res2'],
            'store' => ['res2'],
            'create' => ['res2'],
            'destroy' => ['res2']
        ],
        'CustomizationController'=>[
            'index' => ['res2','cus1'],
            'show' => ['res2','cus1'],
            'edit' => ['res2','cus2'],
            'update' => ['res2','cus2'],
            'store' => ['res2','cus2'],
            'create' => ['res2','cus2'],
            'destroy' => ['res2','cus2'],
            'getCustomization'=> ['res2','cus1'],
            'getOptions'=>['res2','cus1'],
            'changeStatusCustomization' => ['res2','cus2'],
        ],
        'RestaurantsCategoriesController'=>[
            'index' => ['res2','reca1'],
            'show' => ['res2','reca1'],
            'edit' => ['res2','reca2'],
            'update' => ['res2','reca2'],
            'store' => ['res2','reca2'],
            'create' => ['res2','reca2'],
            'destroy' => ['res2','reca2']
        ],
        'RestaurantDeliverySettingsController'=>[
            'index' => ['res2','rds1'],
            'show' => ['res2','rds1'],
            'edit' => ['res2','rds2'],
            'update' => ['res2','rds2'],
            'store' => ['res2','rds2'],
            'create' => ['res2','rds2'],
            'destroy' => ['res2','rds2']
        ],
        'OrdersController'=>[
            'index' => ['res1'],
            'live' => ['res1'],
            'show' => ['res1'],
            'edit' => ['res2'],
            'update' => ['res2'],
            'store' => ['res2'],
            'create' => ['res2'],
            'destroy' => ['res2'],
            'changeStatus'=>['res2'],
            'updateAdminNote' => ['res2'],
            'confirmSendSMS' => ['res2'],
            'confirmSendMail' => ['res2'],
            'confirmResendOrder' => ['res2'],
            'getOrders' => ['res2'],
        ],
        'RestaurantsCuisinesController'=>[
            'index' => ['res2','recs1'],
            'show' => ['res2','recs1'],
            'edit' => ['res2','recs2'],
            'update' => ['res2','recs2'],
            'store' => ['res2','recs2'],
            'create' => ['res2','recs2'],
            'destroy' => ['res2','recs2']
        ],
        'TagController' => [
            'index' => ['res2','t1'],
            'show' => ['res2','t1'],
            'edit' => ['res2','t2'],
            'update' => ['res2','t2'],
            'store' => ['res2','t2'],
            'create' => ['res2','t2'],
            'destroy' => ['res2','t2'],
            'duplicateTag' => ['res2','t2']
        ],
        'OrderRejectReasonController' => [
            'index' => ['rr1'],
            'show' => ['rr1'],
            'edit' => ['rr2'],
            'update' => ['rr2'],
            'store' => ['rr2'],
            'create' => ['rr2'],
            'destroy' => ['rr2'],
            'duplicateOrderRejectReason' => ['rr2']
        ],
        'TimeBasePricingRulesController' => [
            'index' => ['res2','tbpr1'],
            'show' => ['res2','tbpr1'],
            'edit' => ['res2','tbpr2'],
            'update' => ['res2','tbpr2'],
            'store' => ['res2','tbpr2'],
            'create' => ['res2','tbpr2'],
            'destroy' => ['res2','tbpr2'],
            'getList'=> ['res2','tbpr2'],
//            'batch' => ['tbpr2'],
            'duplicateTBP' => ['res2','tbpr2'],
            'changeStatusTimeBasePrising' => ['res2','tbpr2']
        ],
        'TaxesController' => [
            'showTaxInfo' => ['res2'],
            'updateTaxInfo' => ['res2'],
            'createTax' => ['res2'],
        ],
        'ContactController' => [
            'index' => ['res2'],
            'show' => ['res2'],
            'download' => ['res2'],
            'createTax' => ['ta2']
        ],
        'PrintersController' => [
            'index' => ['res1'],
            'show' => ['res1'],
            'edit' => ['res2'],
            'update' => ['res2'],
            'store' => ['res2'],
            'create' => ['res2'],
            'destroy' => ['res2'],
            'export' => ['res2'],
            'duplicatePrinters' => ['res2']
        ],
        'PromotionsController' => [
            'index' => ['res1'],
            'show' => ['res1'],
            'edit' => ['res2'],
            'update' => ['res2'],
            'store' => ['res2'],
            'create' => ['res2'],
            'destroy' => ['res2'],
            'duplicatePromotions' => ['res2']
        ],
        'ReviewsController'=>[
            'index' => ['res1'],
            'show' => ['res1'],
            'changeStatus'=>['res2'],
            'solveSendMail' => ['res2']
        ],
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'code', 'permissions'];

    /**
     * Get the users of role.
     */

    public function canDelete()
    {
        return !count($this->users) > 0;
    }

    public function users()
    {
        //return $this->belongsToMany('App\Models\User')->using('App\Models\UsersRestaurant');
        return $this->belongsToMany('App\Models\User', 'users_restaurants', 'role_id', 'user_id');
    }

    public function restaurant() {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }
}
