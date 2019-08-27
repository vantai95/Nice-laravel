<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersSession extends Model
{
    //
    protected $table = 'users_session';
    protected $fillable = [
        'user_id',
        'district_id',
        'ward_id',
        'province_id'
    ];
}
