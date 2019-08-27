<?php

namespace App\Models;

use Exception, Log, DB;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\File;
use Session;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
    const STATUS_FILTER = [
        'active' => 'active',
        'locked' => 'locked'
    ];

    const ROLE_FILTER = [
        'user' => 'user',
        'admin' => 'admin',
        'customer' => 'customer'
    ];

    const LOGIN_TYPE = [
        'UNKNOWN' => 'Unknown',
        'NORMAL' => 'Password',
        'FACEBOOK' => 'Facebook',
        'GOOGLE_PLUS' => 'GooglePlus'
    ];

    const GENDER = [
        'male' => true,
        'female' => false
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

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
        'full_name', 'email', 'phone', 'password', 'birth_day', 'address', 'image_1',
        'is_locked', 'fb_uid', 'google_uid', 'has_password', 'gender', 'email_verified','banned',
        'gg_token', 'fb_token','account_token','device_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $reset_password_url = url(route('password.reset', $token, false));
        Log::info($reset_password_url);
//        $params = array(
//            'reset_password_url' => $reset_password_url,
//            'full_name' => $this->full_name
//        );
//        Mail::to($this)->send(new SimpleEmailSender('Khôi phục mật khẩu', 'emails.auth.reset_admin', $params, null));
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'user_roles', 'user_id', 'role_id');
    }

    public function user_roles(){
      return $this->hasOne('App\Models\UserRole','user_id');
    }

    public function restaurants(){
        return $this->belongsToMany('App\Models\Restaurant', 'users_restaurants', 'user_id', 'restaurant_id');
    }

    public function isAdmin()
    {
        $role = $this->roles->where('name','=','NiceMiN');
        if ($role->count() > 0) {
          return 1;
        }
        return 0;
    }

    public function isManageAllRestaurant(){
        $role = $this->roles->where('name','=','Manage All Restaurant');
        if ($role->count() > 0) {
          return 1;
        }
        return 0;
    }

    public function isRestaurant()
    {
        $role = $this->roles->where('name','=','Restaurant');
        if ($role->count() > 0) {
          return 1;
        }
        return 0;
    }

    public function userRestaurant()
    {
        if(Session::get('res') == null){
            $data = DB::table('users')
            ->join('users_restaurants','users_restaurants.user_id','=','users.id')
            ->join('restaurants','restaurants.id','=','users_restaurants.restaurant_id')
            ->select('restaurants.*')
            ->where('users.id','=',$this->id)
            ->first();
        }else{
            $res = Session::get('res');
            $data = DB::table('users')
            ->join('users_restaurants','users_restaurants.user_id','=','users.id')
            ->join('restaurants','restaurants.id','=','users_restaurants.restaurant_id')
            ->select('restaurants.*')
            ->where('users.id','=',$this->id)
            ->where('restaurants.id','=',$res->id)
            ->first();
        }

        if ($data) {
            return $data;
        }
        return '';
    }

    public function roleName()
    {
        $user_id = $this->id;
        $userInfo = $this->roles()->select('roles.name')->first();
        if ($userInfo) {
            return $userInfo->name;
        }
        return '';
    }

    public function restaurantId()
    {
        $user_id = $this->id;
        $userInfo = $this->roles()->select('users_restaurants.restaurant_id')->first();
        if ($userInfo) {
            return $userInfo->restaurant_id;
        }
        return '';
    }

    public function roleList()
    {
        $user_id = $this->id;
        $data = DB::table('users_restaurants')
            ->join('roles', function ($join) use ($user_id) {
                $join->on('users_restaurants.role_id', '=', 'roles.id')
                    ->where('users_restaurants.user_id', '=', $user_id);
            })
            ->leftjoin('restaurants', function ($join) use ($user_id) {
                $join->on('users_restaurants.restaurant_id', '=', 'restaurants.id');
            })
            ->select('users_restaurants.id as id', 'roles.name as role_name', 'restaurants.name_en as restaurant_name')->get();
        if ($data) {
            return $data;
        }
        return '';
    }


    public function imageUrl()
    {
        if (!empty($this->image_1) && File::exists(public_path(config('constants.AVATAR_PROFILE_FOLDER')) . '/' . $this->image_1)) {
            return asset(config('constants.AVATAR_PROFILE_FOLDER') . '/' . $this->image_1);
        }

        $facebook = $this->facebookImage();
        if (!empty($facebook)) {
            return $facebook;
        }

        $googlePlus = $this->googlePlusImage();
        if (!empty($googlePlus)) {
            return $googlePlus;
        }

        return asset('common-assets/img/profile.jpg');
    }

    public function imageFullUrl()
    {
        if (!empty($this->image_1) && File::exists(public_path(config('constants.AVATAR_PROFILE_FOLDER')) . '/' . $this->image_1)) {
            return url(config('constants.AVATAR_PROFILE_FOLDER') . '/' . $this->image_1);
        }

        $facebook = $this->facebookImage();
        if (!empty($facebook)) {
            return $facebook;
        }

        $googlePlus = $this->googlePlusImage();
        if (!empty($googlePlus)) {
            return $googlePlus;
        }

        return url('common-assets/img/profile.jpg');
    }

    public function facebookImage()
    {
        if (!empty($this->fb_uid)) {
            return "http://graph.facebook.com/" . $this->fb_uid . "/picture?type=square";
        }

        return null;
    }

    public function googlePlusImage()
    {
        if (!empty($this->google_uid)) {
            try {
                $content = @file_get_contents("http://picasaweb.google.com/data/entry/api/user/" . $this->google_uid . "?alt=json");
                if (strpos($http_response_header[0], "200")) {
                    $d = json_decode($content);
                    return $d->{'entry'}->{'gphoto$thumbnail'}->{'$t'};
                }
            } catch (Exception $ex) {
            }
        }

        return null;
    }

    public function status()
    {
        if ($this->is_locked) {
            return __('admin.users.statuses.locked');
        }
        return __('admin.users.statuses.active');
    }

    public function status_class()
    {
        if ($this->is_locked) {
            return 'm-badge--danger';
        }
        return 'm-badge--success';
    }

    public function loginType()
    {
        $typeText = null;
        if ($this->has_password) {
            $typeText = User::LOGIN_TYPE['NORMAL'];
        }

        if (!empty($this->fb_uid)) {
            if (empty($typeText)) {
                $typeText = User::LOGIN_TYPE['FACEBOOK'];
            } else {
                $typeText .= ', ' . User::LOGIN_TYPE['FACEBOOK'];
            }
        }

        if (!empty($this->google_uid)) {
            if (empty($typeText)) {
                $typeText = User::LOGIN_TYPE['GOOGLE_PLUS'];
            } else {
                $typeText .= ', ' . User::LOGIN_TYPE['GOOGLE_PLUS'];
            }
        }

        if (empty($typeText)) {
            return User::LOGIN_TYPE['UNKNOWN'];
        }

        return $typeText;
    }


    public function disableRole()
    {
        if (empty($this->email)) {
            return false;
        }
        return true;
    }

    public function allPermissions()
    {
        $result = [];
        //check if user is super admin
        $email = $this->email;
        if ($this->isAdmin()) {
            foreach (Role::PERMISSIONS as $name => $permission) {
                $result[$permission['code']] = true;
            }
        } else {
            //save user's permissions after login
            $permissions = $this->getPermissions();
            foreach ($permissions as $permission) {
                $ps = explode(',', $permission->permissions);
                foreach ($ps as $p) {
                    $result[$p] = true;
                }
            }
        }
        return $result;
    }

    public function getPermissions()
    {
        $user_id = $this->id;
        $data = $this->roles()->select('roles.permissions as permissions')->get();
        if ($data) {
            return $data;
        }
        return '';
    }

    public function orders(){
        return $this->hasMany('App\Models\Order','user_id')->get();
    }
}
