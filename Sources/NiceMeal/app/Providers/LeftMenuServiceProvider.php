<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Session,URL,Auth;
use App\Services\CommonService;
use App\Services\Permissions;

class LeftMenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
      $this->defineGate();
      view()->composer('*', function ($view) {
        if(Auth::check()){
          $allUserPermissions = Auth::user()->allPermissions();
            $left_menu = file_get_contents(__DIR__.'/../../storage/left-menu.json');
            $left_menu = json_decode($left_menu);
            $res = Session::get('res');
            $left_menu = $left_menu->left_menu;
              foreach($left_menu as $key => &$menu){
                $menu->key = $key;
                $this->checkMenu($menu,$left_menu,$res,$allUserPermissions);
              }
            $view->with('left_menu',array_values($left_menu));
        }

      });
    }

    public function checkMenu($menu, &$left_menu,$res,$allUserPermissions){
      if(!Gate::check($menu->gate)){
        unset($left_menu[$menu->key]);
      }else{
        if($res != null){
            $menu->url = str_replace("{restaurant_slug}",$res->res_Slug,$menu->url);
        }
        if($menu->url != "" && $menu->url != "#" && !Permissions\CheckService::checkPermission($menu->url,$allUserPermissions)){
          unset($left_menu[$menu->key]);
        }
        if(isset($menu->children)){
          foreach($menu->children as $sub_key => &$sub_menu){
            $sub_menu->key = $sub_key;
            $this->checkMenu($sub_menu,$menu->children,$res,$allUserPermissions);
          }
          if(count($menu->children) == 0){
            unset($left_menu[$menu->key]);
          }
        }

      }
    }

    public function defineGate(){
      Gate::define('', function ($user) {
        return true;
      });

      Gate::define('is-admin-and-dont-has-session', function ($user) {
        return $user->isAdmin() && !Session::has('res');
      });

      Gate::define('manage-restaurant-or-is-admin',function($user){
        return $user->restaurants->count() > 1 || $user->isAdmin() || $user->isManageAllRestaurant();
      });

      Gate::define('manage-restaurant-and-is-admin',function($user){
        return CommonService::checkIfManageManyRestaurants($user->id) && $user->isAdmin();
      });

      Gate::define('is-admin',function($user){
        return $user->isAdmin();
      });

      Gate::define('is-admin-or-manage-all-restaurant',function($user){
        return $user->isAdmin() || $user->isManageAllRestaurant();
      });

      Gate::define('is-admin-or-manage-all-restaurant-and-dont-has-session',function($user){
        return ($user->isAdmin() || $user->isManageAllRestaurant()) && !Session::has('res');
      });

      Gate::define('check-restaurant-management',function($user){
        $res = Session::get('res');
        return $res != null && CommonService::checkRestaurantManagement($res->res_Slug);
      });

      Gate::define('has-restaurant-session',function($user){
        $res = Session::get('res');
        return $res != null;
      });
    }
}
