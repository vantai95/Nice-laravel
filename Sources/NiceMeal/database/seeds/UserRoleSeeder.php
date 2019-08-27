<?php

use Illuminate\Database\Seeder;
use App\Models\UserRole;
use App\Models\UsersRestaurant;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user_restaurants = UsersRestaurant::select('users_restaurants.role_id','users_restaurants.user_id','roles.name')
        ->join('roles','roles.id','=','users_restaurants.role_id')->get();

        $user_restaurants = $user_restaurants->unique(function($item){
            return $item->user_id.$item->role_id;
        });

        $user_with_restaurants_role = $user_restaurants->filter(function($item){
            return $item->name == 'Restaurant';
        });

        $user_with_manage_role = $user_restaurants->filter(function($item){
          return $item->name == 'Manage All Restaurant' || $item->name == 'NiceMiN';
        });

        $user_roles = [];
        foreach($user_with_manage_role as $temp_role){
          $user_role = [];
          $user_role['user_id'] = $temp_role->user_id;
          $user_role['role_id'] = $temp_role->role_id;
          array_push($user_roles,$user_role);
        }

        foreach($user_with_restaurants_role as $temp_role){
          if($user_with_manage_role->where('user_id','=',$temp_role->user_id)->count() == 0){
            $user_role = [];
            $user_role['user_id'] = $temp_role->user_id;
            $user_role['role_id'] = $temp_role->role_id;
            array_push($user_roles,$user_role);
          }
        }
        UserRole::insert($user_roles);
    }
}
