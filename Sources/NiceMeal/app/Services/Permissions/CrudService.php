<?php
namespace App\Services\Permissions;

use App\Models\Role;
use Auth;


class CrudService{
  public static function getAllRole(){
    $query = self::roleSelectField();
    $query = self::exceptRole($query);
    return $query;
  }

  public static function exceptRole($query){
    if(Auth::user()->isAdmin()){
      $query = $query->where(function($whereClause){
        $whereClause->where('roles.name','<>','NiceMiN');
      });
    }else if(Auth::user()->isManageAllRestaurant()){
      $query = $query->where(function($whereClause){
        $whereClause->where('roles.name','<>','NiceMiN')->where('roles.name','<>','Manage All Restaurant');
      });
    }
    return $query;
  }

  public static function roleSelectField(){
    $query = Role::select('id','name','permissions');
    return $query;
  }

  public static function findRole($id){
    $query = self::roleSelectField();
    $query = self::exceptRole($query);
    $role = $query->find($id);
    if($role == null){
      return null;
    }else{
      $role->permissions = explode(',',$role->permissions);
      return $role;
    }
  }

  public static function updateRole($role,$data){
    $role->name = $data['name'];
    $role->permissions = $data['permissions'];
    $role->save();
  }

  public static function getAllPermission(){
    $permissions = collect(Role::PERMISSIONS);
    $totalPermissions = $permissions->count();
    $itemEachColumn = ceil($permissions->count()/3);
    $firstPage = $permissions->forPage(1,$itemEachColumn);
    $secondPage = $permissions->forPage(2,$itemEachColumn);
    $thirdPage = $permissions->forPage(3,$itemEachColumn);
    return [$firstPage,$secondPage,$thirdPage];
  }
}
