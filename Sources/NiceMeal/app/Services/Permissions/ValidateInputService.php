<?php
namespace App\Services\Permissions;

class ValidateInputService{

  public static function validateInput($request){
    if($request->input('permissions') == null){
      return [];
    }else{
      return array_keys($request->input('permissions'));
    }

  }

}
