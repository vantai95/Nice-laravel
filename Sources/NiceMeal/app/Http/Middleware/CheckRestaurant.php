<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\Restaurant;
use Auth,Session,DB, Route;

class CheckRestaurant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    private $restaurant;
    private $id;
    private $model;
    private $method;
    private $required_method;
    private $slug;
    public function handle($request, Closure $next)
    {
        // if(Auth::user()->isRestaurant()){
        //     $res = Restaurant::where('id','=',Auth::user()->userRestaurant()->id)
        //     ->select(DB::raw('restaurants.*,restaurants.slug as res_Slug'))
        //     ->first();
        //     Session::put('res',$res);
        // }else if(Auth::user()->isAdmin()){

        // }
        $this->slug = $request->route()->parameters()['restaurant_slug'];
        $controller_and_method = explode('@',Route::currentRouteAction());
        $this->required_method = $controller_and_method[0]::required_method;
        $this->method = $controller_and_method[1];
        $this->model = $controller_and_method[0]::model;

        if($this->checkRequiredMethod()){
            $this->id = $request->route()->parameters()[$controller_and_method[0]::default_index];
        }

        return $this->generalCheck($request,$next);

    }

    public function generalCheck($request,$next){
        if(Auth::user()->isRestaurant()){
            return $this->restaurantUserCheck($request,$next);
        }else if(Auth::user()->isAdmin() || Auth::user()->isManageAllRestaurant()){
            return $this->adminUserCheck($request,$next);
        }
    }

    public function restaurantUserCheck($request,$next){
        $this->restaurant = Restaurant::where('id','=',Auth::user()->userRestaurant()->id)
            ->select(DB::raw('restaurants.*,restaurants.slug as res_Slug'))
            ->first();
            Session::put('res',$this->restaurant);
        return $this->checkRestaurantOwner($request,$next);

    }

    public function adminUserCheck($request,$next){
        if(!Session::get('res')){
            return redirect('admin/restaurants');
        }else{
            $this->restaurant = Session::get('res');
            return $this->checkRestaurantOwner($request,$next);
        }
    }

    public function checkRestaurantOwner($request,$next){
        if($this->slug == $this->restaurant->res_Slug){
            if($this->checkRequiredMethod()){
                if($this->checkIfBelongtoRes()){
                    return $next($request);
                }else{
                    return $this->returnOrRedirectOnFail($request,$next);
                }
            }else{
                return $next($request);
            }
        }else{
            return $this->returnOrRedirectOnFail($request,$next);
        }
    }

    public function returnOrRedirectOnFail($request,$next){
        if($request->ajax()){
            return response()->json(['error'=>"Bạn không có quyền"]);
        }else{
            Session::flash('flash_error', 'Bạn không có quyền vào trang!');
            return redirect('admin');
        }
    }

    public function checkRequiredMethod(){
        return (in_array($this->method,$this->required_method)) ? 1 : 0;
    }

    public function checkIfBelongtoRes(){
        if($this->model == Restaurant::class){
            if($this->model::where('id',$this->id)->count() > 0){
                return 1;
            }else{
                return 0;
            }
        }else{
            if($this->model::where('id',$this->id)->where('restaurant_id',$this->restaurant->id)->count() > 0){
                return 1;
            }else{
                return 0;
            }
        }
    }
}
