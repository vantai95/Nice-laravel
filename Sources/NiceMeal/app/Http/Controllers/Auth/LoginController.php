<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $redirectTo = '/admin';

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        setcookie("location_info", "", time() - 1);
        if (session()->has('redirect_url')) {
            return session()->pull('redirect_url');
        } else {
            Session::flash('flash_message', 'Login successfully!');
            if (Auth::user()->isAdmin() || Auth::user()->isRestaurant() || Auth::user()->isManageAllRestaurant()) {
                return '/admin';
            } else {
                /*$user_id = Auth::user()->id;
                $sessionUser = DB::table('users_session')
                                ->where('user_id', $user_id)
                                ->get();
                if ($sessionUser->count() == 1 ) {
                    foreach ($sessionUser as $session) {
                        $districtId = $session->district_id;
                        $wardId     = $session->ward_id;
                    }
                    $districtData = District::find($districtId);
                    $wardData = Ward::find($wardId);
                    if($wardId == NULL) {
                        $url = route('locations.show',$districtData->slug);
                        return $url;
                    } else {
                        $url = route('locations.show',$districtData->slug).'?ward='.$wardData->id;
                        return $url;
                    }
                }*/
                return '/';
            }
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Socialite Login
     *
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
        // return Socialite::driver($provider)->fields([
        //     'first_name', 'last_name', 'email', 'gender', 'birthday','mobile_phone'
        // ])->scopes([
        //     'email', 'user_birthday','mobile_phone'
        // ])->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
        // $facebook_user = Socialite::driver('facebook')->fields([
        //     'first_name', 'last_name', 'email', 'gender', 'birthday','mobile_phone'
        // ])->user();
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        Session::flash('flash_message', trans('auth.flash_message.success'));
        return redirect('/');
    }

    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('fb_uid', $user->id)
            ->orWhere('email', $user->getEmail())
            ->first();

        if ($authUser) {
            return $authUser;
        } elseif ($provider == 'facebook') {
            return User::create([
                'full_name' => $user->name,
                'email' => $user->email,
                'fb_uid' => $user->id,
                'has_password' => false,
            ]);
        } else {
            return User::create([
                'full_name' => $user->getName(),
                'email' => $user->getEmail(),
                'google_uid' => $user->id,
                'password' => bcrypt('123456')
            ]);
        }
    }

    public function logout()
    {
        $user = Auth::user();
        Session::forget('res');
        Session::flush();
        Auth::logout();
        return redirect()->back();
    }

    /*load config login facebook and google
    */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        $hasError = false;
        // get all permissions of user
        if (Auth::user()->is_locked) {
            Session::flash('flash_error', trans('auth.flash_message.locked_error'));
            $hasError = true;
        }
        if (Auth::user()->banned) {
            Session::flash('flash_error', trans('auth.flash_message.banned_error'));
            $hasError = true;
        }
        if ($hasError) {
            Session::forget('res');
            Auth::logout();
            return redirect()->back();
        }
        session(['permissions' => Auth::user()->allPermissions()]);
    }

    public function newLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->input('email'))->first();
        if($user) {
            $validator->after(function ($validator) use ($request, $user) {
                if($user){
                    if ( !\Hash::check($request->input('password'), $user->password) ) {
                        $validator->errors()->add('password', 'Your current password is incorrect.');
                    }
                }else{
                    $validator->errors()->add('email', 'This email is not exist');
                }

            });
        }

        // resturn response if validation success
        if ($validator->passes()) {
            if (auth()->attempt(array('email' => $request->input('email'),
                'password' => $request->input('password')),true))
            {
                return response()->json(['success' => true], 200);
            }
            else return response()->json(['wrong_email_res' => 'Sorry User not found.'], 500);
        }
        else return response()->json(['errors_response' => $validator->errors()], 500);
        
    }
}
