<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RestaurantService;
use App\Models\Tag;
use App\Models\Restaurant;
use App\Models\Country;
use App\Models\Province;
use Session,App;

class UserLayoutServiceProvider extends ServiceProvider
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
        //
        view()->composer('newuser.*',function($view){
          $lang = Session::get('locale');
          $leaderBoard = RestaurantService::getLeaderBoardList($lang);
          $restaurantServices = Restaurant::SERVICES_FILTER;
          $countries = Country::select('id',"name_$lang as name")->get();
          $provinces = Province::select('id',"name_$lang as name")->get();
          $cuisines = Tag::where('type', Tag::TYPE['cuisine'])->select("name_$lang as name", 'tags.*')->get();
          $categories = Tag::where('type', Tag::TYPE['category'])->select("name_$lang as name", 'tags.*')->get();
          $view->with('restaurantServices',$restaurantServices)
          ->with('countries',$countries)
          ->with('leaderBoard',$leaderBoard)
          ->with('cuisines',$cuisines)
          ->with('categories',$categories)
          ->with('provinces',$provinces);
        });
    }
}
