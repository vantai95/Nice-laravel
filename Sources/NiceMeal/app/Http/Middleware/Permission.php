<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Services\CommonService;
use App\Services\Permissions;
use Closure;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $actionName = explode('\\', $request->route()->getActionName())[count(explode('\\', $request->route()->getActionName())) - 1];

        $controller = explode('@', $actionName)[0];
        $action = explode('@', $actionName)[1];

        $requiredPermissions = !empty(Role::CONTROLLERS[$controller][$action]) ? Role::CONTROLLERS[$controller][$action] : [];

        if(!Auth::user()) {
            Session::flash('flash_error', 'You are not login!');
            return redirect('/');
        }
        if(Auth::user()->isAdmin()){
            return $next($request);
        }

        $allPermissionsOfUser = Auth::user()->allPermissions();
        Auth::user()->load(['restaurants' => function($query){
          $query->select(DB::raw('restaurants.*,restaurants.slug as res_Slug'));
        }]);

        if(Auth::user()->isRestaurant() && Auth::user()->restaurants->count() == 0){
            Session::forget('res');
            Auth::logout();
            Session::flash('flash_error', 'Bạn không quản lý nhà hàng nào!');
            return redirect('/login');
        }

        if(Permissions\CheckService::doCheck($allPermissionsOfUser,$requiredPermissions)){
          return $next($request);
        }

        if(Auth::user()->isManageAllRestaurant()){
            Session::flash('flash_error', 'Bạn không được cấp quyền này!');
            return redirect('/admin');
        }

        Session::flash('flash_error', 'Bạn không có quyền vào trang!');
        return redirect('/login');
    }
}
