<?php
namespace App\Services\Permissions;

use Auth;
use App\Models\Role;

class CheckService{

  public static function checkPermission($url,$allPermissions){
    $route = app('router')->getRoutes()->match(app('request')->create($url));

    $actionName = explode('\\', $route->getActionName())[count(explode('\\', $route->getActionName())) - 1];

    $controller = explode('@', $actionName)[0];
    $action = explode('@', $actionName)[1];
    $requiredPermissions = !empty(Role::CONTROLLERS[$controller][$action]) ? Role::CONTROLLERS[$controller][$action] : [];
    return self::doCheck($allPermissions,$requiredPermissions);
  }

  public static function doCheck($allPermissions,$requiredPermissions){
    $result = true;
    foreach($requiredPermissions as $requiredPermission){
      $result = $result && isset($allPermissions[$requiredPermission]) && $allPermissions[$requiredPermission];
    }
    return $result;
  }
}
