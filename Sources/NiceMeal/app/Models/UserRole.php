<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = 'user_roles';
    protected $fillable = ['restaurant_id', 'role_id','user_id'];

}
