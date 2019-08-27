<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth,Session,DB;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Services\CommonService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Schema::defaultStringLength(191);
        //
        view()->composer('admin.*', function ($view) {
            $res = new \StdClass;
            $res->name_en = '';
            $res->res_Slug = 'unset';
            // $res = null;
            if(Auth::check()){
                if(Auth::user()->isRestaurant() && !Session::get('res')){
                        $res = Auth::user()->restaurants->first();
                        if(Auth::user()->restaurants->count() == 1){
                          Session::put('res',$res);
                        }
                }
                else if(((Auth::user()->isAdmin() || Auth::user()->isManageAllRestaurant()) && Session::get('res')) || (Auth::user()->isRestaurant() && Session::get('res'))){
                    $res = Session::get('res');
                }
            }
            $view->with('res',$res);
        });

        Validator::extend('greater_than_field', function($attribute, $value, $parameters, $validator) {
            $min_field = $parameters[0];
            $data = $validator->getData();
            $min_value = $data[$min_field];
            return $value > $min_value;
        });

        Validator::extend('old_password', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value,Auth::user()->password);
        });

         Validator::extend('at_least_one',function ($attribute, $value, $parameter, $validator){
            foreach ($value as $key => $val){
                if($val > 0){
                    return true;
                }
            }
            return false;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->useStoragePath(config('app.app_storage'));

    }
}
