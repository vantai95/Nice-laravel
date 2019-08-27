<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\UsersRestaurant;

class NiceMinUserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $email = 'thaibaminh2512@gmail.com';
      $manageAllRestaurantRoleName = "Manage All Restaurant";
      //create role
      if(Role::where('name','=','NiceMiN')->count() == 0){
        $role = [];
        $role['name'] = "NiceMiN";
        $role_id = Role::create($role)->id;
      }else{
        $role_id = Role::where('name','=','NiceMiN')->first()->id;
      }

      //create unique NiceMiN user
      if(User::where('email','=','thaibaminh2512@gmail.com')->count() == 0){
        $user = [];
        $user['full_name'] = "Thái Bá Minh";
        $user['email'] = $email;
        $user['password'] = bcrypt('NiceMiN@123');
        $user_id = User::create($user)->id;

        UsersRestaurant::create([
          'user_id' => $user_id,
          'role_id' => $role_id
        ]);
      }else{
        $user = User::where('email','=',$email)->first();
        if(UsersRestaurant::where('user_id',$user->id)->where('role_id',$role_id)->count() == 0){
          UsersRestaurant::create([
            'user_id' => $user->id,
            'role_id' => $role_id
          ]);
        }

      }

      $oldAdminRole = Role::where('name', 'Admin')->first();
      if($oldAdminRole != null){
        $oldAdminRole->name = $manageAllRestaurantRoleName;
        $oldAdminRole->save();
      }
    }
}
