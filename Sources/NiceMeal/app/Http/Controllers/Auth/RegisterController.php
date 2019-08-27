<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Session;
use App\Mail\RegisterToMail;
use App\Mail\ActiveAccountMail;
use Carbon\Carbon;
use Log, CommonService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'full_name' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/',
            //'phone' => 'required|min:10|max:11|unique:users,phone|regex:/^[0-9]+$/',
            'phone' => 'required|min:8|unique:users,phone|regex:/^[0-9]+$/',
        ], $this->validationMessages());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $this->redirectTo = '/';
        Session::flash('flash_message', 'Registered successfully!');

        $currentTime = time();
        $accountToken = md5(date('Y-m-d H:i:s', $currentTime) . $data['email']);
        $user_id = User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
            'account_token' => $accountToken
        ])->id;

        // TODO: send mail to user for verify register
        $userInfo = User::where('id', $user_id)->first();
        $isTakeawayDomain = CommonService::isTakeawayDomain();
        \Mail::to($data['email'])->send(new ActiveAccountMail($userInfo, [], $accountToken, $isTakeawayDomain));
        return $userInfo;
    }

    private function validationMessages()
    {
        return [
            'full_name.regex' => trans('auth.register.validate_full_name'),
            'email.required' => trans('auth.register.validate_email'),
            'password.required' => trans('auth.register.validate_password_required'),
            'password.regex' => trans('auth.register.validate_password_regex'),
            'password.confirmed' => trans('auth.register.validate_password_confirmed'),
            'phone.regex' => trans('auth.register.validate_phone'),
        ];
    }

    /*load config login facebook and google
     * */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function verify($code)
    {

        try {
            $userData = decrypt($code);
            $user = User::where('id', '=', $userData['id'])
                ->where('email', '=', $userData['email'])->first();

            if ($user == null) // redirect error url
            {
                return view('auth.verify.error');
            } else {
                if ($user->email_verified != 1) {

                    $timeThought = Carbon::parse($user->email_verify_sent_at)->diffInHours(Carbon::now());
                    $isUrlExpired = ($timeThought < 48) ? false : true;

                    if ($isUrlExpired == true) {
                        // set time expired
                        $user->email_verify_sent_at = Carbon::now();
                        $user->save();

                        // TODO: send mail to user for verify register
                        $user = User::where('email', '=', $user->email)->first();
                        $userData = array("id" => $user->id, "email" => $user->email);
                        $verify_url = url('/auth/verify') . '/' . encrypt($userData);
                        Mail::to($user->email)->send(new RegisterToMail($user, $verify_url));
                        return view('auth.verify.expired');
                    } else {
                        $user->email_verified = 1;
                        $user->save();
                        // redirect success url
                        return view('auth.verify.success');
                    }
                } else {
                    return view('auth.verify.success');
                }
            }

        } catch (DecryptException $e) {
            // redirect error url
            return view('auth.verify.error');
        }
    }


    public function newRegister(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/',
            'phone' => 'required|min:8|unique:users,phone|regex:/^[0-9]+$/',
        ]);
        $currentTime = time();
        if ($validators->fails()) {
            return response()->json([
                "success" => false,
                "errors_message" => $validators->messages()
            ], 500);
        } else {
            $user = new User([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone' => $request->phone,
                'account_token' => md5(date('Y-m-d H:i:s', $currentTime) .$request->email)
            ]);
            $user->save();
            $user_id = $user->id;
            $accountToken = $user->account_token;
            // TODO: send mail to user for verify register
            $userInfo = User::where('id', $user_id)->first();

            $isTakeawayDomain = CommonService::isTakeawayDomain();
            \Mail::to($user->email)->send(new ActiveAccountMail($userInfo, [], $accountToken, $isTakeawayDomain));

            // resturn response if validation success
            Session::flash('flash_message', 'Registered successfully!');

            Auth::login($user);

            return response()->json([
                'success' => true,
                'data' => $userInfo
            ], 200);
        }
    }
}
