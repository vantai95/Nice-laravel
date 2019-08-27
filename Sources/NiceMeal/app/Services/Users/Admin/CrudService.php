<?php
namespace App\Services\Users\Admin;

use App\Models\User;
use App\Models\UserRole;
use App\Models\UsersRestaurant;
use App\Models\Role;
use Auth,DB;

class CrudService{

  public static function getUserList(){
    $query = User::select('users.*','user_roles.role_id','roles.name as role_name')
        ->orderBy('users.full_name', 'asc')->leftJoin('user_roles',function($join){
          $join->on('user_roles.user_id','=','users.id')->join('roles','roles.id','=','user_roles.role_id');
        });
    $query = self::exceptRole($query);
    return $query;
  }

  public static function getUser($id){
    $query = User::select('users.*','user_roles.role_id','roles.name as role_name')
        ->orderBy('users.full_name', 'asc')->leftJoin('user_roles',function($join){
          $join->on('user_roles.user_id','=','users.id')->join('roles','roles.id','=','user_roles.role_id');
        })->with('restaurants');
    $query = self::exceptRole($query);
    return $query->findOrFail($id);
  }

  public static function exceptRole($query){
    if(Auth::user()->isAdmin()){
      $query = $query->where(function($whereClause){
        $whereClause->where('roles.name','<>','NiceMiN')->orWhereNull('roles.name');
      });
    }else if(Auth::user()->isManageAllRestaurant()){
      $query = $query->where(function($whereClause){
        $whereClause->where('roles.name','<>','NiceMiN')->where('roles.name','<>','Manage All Restaurant')->orWhereNull('roles.name');
      });
    }
    return $query;
  }

  public static function updateData($id,$request,$isMyProfile){
    DB::transaction(function() use ($id,$request,$isMyProfile) {
      $user = User::findOrFail($id);
      $requestData = $request->all();
      if (!$isMyProfile) {
          unset($requestData['email']);
          if(isset($requestData['is_locked']) == false) $requestData['is_locked'] = 0;
      } else {
          // unset($requestData['role_id']);
          // unset($requestData['is_locked']);
      }

      $user->update($requestData);

      if($requestData['role_id'] == null){
        return;
      }

      $role = Role::findOrFail($requestData['role_id']);

      if(Auth::user()->roles[0]->name == $role->name){
        return;
      }

      $userRole = UserRole::where('user_id','=',$user->id)->first();
      if($userRole == null){
        $userRole = new UserRole;
        $userRole->user_id = $id;
      }
      $userRole->role_id = $requestData['role_id'];
      $userRole->save();


      UsersRestaurant::where('user_id','=',$id)->delete();

      if($role->name != "NiceMiN" && $role->name != "Manage All Restaurant" && array_key_exists('restaurants',$requestData)){
        $userRestaurants = [];
        foreach($requestData['restaurants'] as $res){
          $data = [];
          $data['user_id'] = $id;
          $data['role_id'] = $userRole->role_id;
          $data['restaurant_id'] = $res;
          array_push($userRestaurants,$data);
        }
        UsersRestaurant::insert($userRestaurants);
      }
    });
  }

}
