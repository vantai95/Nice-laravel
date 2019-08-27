<?php

namespace App\Models;

use Exception, Log, DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\File;

class Upload extends Authenticatable
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'uploads';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'file_name','extension', 'restaurant_id', 'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //Get image URL
    public function imageUrl()
    {
        if (!empty($this->file_name) && File::exists(public_path(config('constants.UPLOAD.IMAGES')) . '/' . $this->file_name)) {
            return url(config('constants.UPLOAD.IMAGES') . '/' . $this->file_name);
        }
        return url(config('constants.DEFAULT.IMAGE'));
    }

    public function restaurant() {
        return $this->belongsTo('App\Models\Restaurant', 'restaurant_id');
    }
}
