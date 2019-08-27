<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth,Validator;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\PasswordReset;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use GuzzleHttp\Client;
use DB;

class AuthController extends Controller
{
    /**
     * @api {POST} /api/login Authenticate
     * @apiName Authenticate
     * @apiVersion 1.0.0
     * @apiDescription Login
     * @apiGroup AUTHENTICATE
     *
     * @apiHeader {String} CLI-HEADER The key to access API server
     * @apiHeader {String} LANGUAGE Language Code
     *
     * @apiParam (body){String} user_name Email
     * @apiParam (body){String} password Password
     *
     * @apiParamExample Request-Example:
     *     {
     *       "email":"nguyenptt@imt-soft.com",
     *       "password":"xxxxxx"
     *     }
     *
     * @apiSuccessExample Success Response
     *       HTTP/1.1 200 OK
     *       {
     *          "success": true,
     *          "data": {
     *            "id": 1
     *            "token": "0x2E49Cff4906d8f4890fb08E287f6179781F6165C",
     *            "name": "Nguyen Phan",
     *            "email": "nguyenptt@imt-soft.com",
     *            "role": "Admin",
     *            "role_id": 1,
     *          }
     *        }
     *
     * @apiSuccessExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "success": false
     *       "error_code": "USER01"
     *       "message": "Error, please check you params"
     *     }
     */
    public function login(Request $request){

        $validators = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if($validators->fails()){
            return response()->json([
                "success" => false,
                "error_code" => "USER01",
                "message" => $validators->messages()
            ], 401);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if(!Auth::attempt($credentials)){
            return response()->json([
                "success" => false,
                "error_code" => "USER01",
                "message" => [
                    "password" => [
                        "Invalid password"
                    ]
                ]
            ], 401);
        }
        $user = $request->user();
        $user->device_token = ($request->input('device_token') !== null) ? $request->input('device_token'): null;
        $user->save();
        if(Auth::user()->isAdmin() || Auth::user()->isRestaurant()){
            $role = $user->roles[0];
        }
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'success' => true,
            'data' => [
                'token' => $tokenResult->accessToken,
                'name' => $user->full_name,
                'email' => $user->email,
                'gender' => $user->gender,
                'phone' => $user->phone,
                'role' => !empty($role) ? $role->name : '',
                'role_id' => !empty($role) ? $role->id : '',
                'id' => $user->id
            ]
        ]);
    }

    /**
     * @api {POST} /api/register Register
     * @apiName Register
     * @apiVersion 1.0.0
     * @apiDescription Register
     * @apiGroup AUTHENTICATE
     *
     * @apiHeader {String} CLI-HEADER The key to access API server
     * @apiHeader {String} LANGUAGE Language Code
     *
     * @apiParam (body){String} email Email
     * @apiParam (body){String} password Password
     * @apiParam (body){String} confirmed_password Confirmed Password
     * @apiParam (body){String} full_name Full Name
     * @apiParam (body){String} phone_number Phone Number
     * @apiParam (body){String} gender Gender(F/M)
     * @apiParam (body){Number} day Day
     * @apiParam (body){Number} month Month
     * @apiParam (body){Number} year Year
     *
     * @apiParamExample Request-Example:
     *     {
     *       "email": "nguyenptt@imt-soft.com",
     *       "password": "xxxxxx",
     *       "confirmed_password": "xxxxxx",
     *       "full_name": "Nguyen Phan",
     *       "phone_number": "0987654321",
     *       "gender": "female",
     *       "day": "1",
     *       "month": "1",
     *       "year": "1990"
     *     }
     *
     * @apiSuccessExample Success Response
     *       HTTP/1.1 200 OK
     *       {
     *          "success": true,
     *          "data": {
     *             "id": 1
     *             "token": "0x2E49Cff4906d8f4890fb08E287f6179781F6165C",
     *             "name": "Nguyen Phan",
     *             "email": "nguyenptt@imt-soft.com",
     *          }
     *        }
     *
     * @apiSuccessExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "success": false
     *       "error_code": "USER02"
     *       "message": "Error, please check you params"
     *     }
     */
    public function signup(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
            //'phone' => 'required|min:10|max:11|unique:users,phone|regex:/^[0-9]+$/',
            'phone' => 'required|min:8|unique:users,phone|regex:/^[0-9]+$/',
            'gender' => 'required|in:male,female',
            'day' => 'required|numeric',
            'month' => 'required|numeric',
            'year' => 'required|numeric'
        ]);
        if($validators->fails()){
            return response()->json([
                "success" => false,
                "error_code" => "USER02",
                "message" => $validators->messages()
            ], 401);
        }

        $user = new User([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_day' => $request->year.'-'.$request->month.'-'.$request->day,
            'device_token' => $request->device_token
        ]);
        $user->save();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(1);
        return response()->json([
            'success' => true,
            'data' => [
                'token' => $tokenResult->accessToken,
                'name' => $user->full_name,
                'email' => $user->email,
                'gender' => $user->gender,
                'phone' => $user->phone,
                'id' => $user->id
            ]
        ]);
    }

    /**
     * @api {POST} /api/change-password Change Password
     * @apiName Change Password
     * @apiVersion 1.0.0
     * @apiDescription Change password
     * @apiGroup AUTHENTICATE
     *
     * @apiHeader {String} CLI-HEADER The key to access API server
     * @apiHeader {String} LANGUAGE Language Code
     * @apiHeader {String} TOKEN Token
     *
     * @apiParam (body){String} old_password Old password
     * @apiParam (body){String} password New password
     * @apiParam (body){String} password_confirmation Confirm new password
     *
     * @apiParamExample Request-Example:
     *     {
     *       "old_password": "xxxxxx",
     *       "password": "yyyyyy"
     *       "password_confirmation": "yyyyyy"
     *     }
     *
     * @apiSuccessExample Success Response
     *       HTTP/1.1 200 OK
     *       {
     *          "success": true,
     *          "message": "Password has been changed"
     *        }
     *
     * @apiSuccessExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "success": false
     *       "error_code": "USER02"
     *       "message": "Error, please check you params"
     *     }
     */
    public function changePassword(Request $request){
        $user = $request->user();
        $requestData = $request->all();

        $validators = Validator::make($request->all(), [
            'old_password' => 'required|old_password',
            'password' => 'required|min:8|different:old_password',
            'password_confirmation' => 'required|min:8|same:password',
        ]);

        if($validators->fails()){
            return response()->json([
                "success" => false,
                "error_code" => "USER03",
                "message" => $validators->messages()
            ], 401);
        }

        $userData = User::where('id',$user->id)->first();

        $newPassword = Hash::make($requestData['password']);

        try{
            $userData->update(['password' => $newPassword]);
        }catch(\Exception $exception){
            return response()->json([
                "success" => false,
                "error_code" => "USER03",
                "message" => "Update fail"
            ]);
        }
        return response()->json([
            "success" => true,
            "message" => "Password has been changed"
        ]);
    }

    /**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */

    /**
     * @api {POST} /api/password/create Reset Password
     * @apiName Reset Password
     * @apiVersion 1.0.0
     * @apiDescription Reset Password
     * @apiGroup AUTHENTICATE
     *
     * @apiHeader {String} CLI-HEADER The key to access API server
     * @apiHeader {String} LANGUAGE Language Code
     *
     * @apiParam (body){String} email Email
     *
     * @apiParamExample Request-Example:
     *     {
     *       "email": "nguyenptt@imt-soft.com",
     *     }
     *
     * @apiSuccessExample Success Response
     *       HTTP/1.1 200 OK
     *       {
     *          "success" => true,
     *          "message" => "We have e-mailed your password reset link!"
     *        }
     *
     * @apiSuccessExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *        "success": false
     *        "error_code": "USER03"
     *        "message": "Error, please check you params"
     *     }
     */

    public function create(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'email' => 'required|string|email',
        ]);

        if($validators->fails()){
            return response()->json([
                "success" => false,
                "error_code" => "USER04",
                "message" => $validators->messages()
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user)
            return response()->json([
                "success" => false,
                "error_code" => "USER04",
                'message' => 'We can\'t find a user with that e-mail address.'
            ], 404);
        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => str_random(60)
             ]
        );
        if ($user && $passwordReset)
            $user->notify(
                new PasswordResetRequest($passwordReset->token)
            );
        return response()->json([
            "success" => true,
            'message' => 'We have e-mailed your password reset link!'
        ]);
    }

    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)
            ->first();
        if (!$passwordReset)
            return response()->json([
                "success" => false,
                "error_code" => "USER04",
                'message' => 'This password reset token is invalid.'
            ], 404);
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                "success" => false,
                "error_code" => "USER04",
                'message' => 'This password reset token is invalid.'
            ], 404);
        }
        return response()->json($passwordReset);
    }


    public function reset(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'token' => 'required|string'
        ]);

        if($validators->fails()){
            return response()->json([
                "success" => false,
                "error_code" => "USER04",
                "message" => $validators->messages()
            ], 401);
        }

        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();
        if (!$passwordReset)
            return response()->json([
                "success" => false,
                "error_code" => "USER04",
                'message' => 'This password reset token is invalid.'
            ], 404);
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user){
            return response()->json([
                "success" => false,
                "error_code" => "USER04",
                'message' => 'We can\'t find a user with that e-mail address.'
            ], 404);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess($passwordReset));
        return response()->json([
            "success" => true,
            "message" => "Your password has been reset",
            "data" => $user
        ]);
    }

    /**
     * @api {POST} /api/gg-authenticate Authenticate by Google
     * @apiName Authenticate by Google
     * @apiVersion 1.0.0
     * @apiDescription Google Authenticate
     * @apiGroup AUTHENTICATE
     * @apiHeader {String} CLI-HEADER The key to access API server
     * @apiHeader {String} LANGUAGE Language Code
     *
     * @apiParam (body){String} email Google email.
     * @apiParam (body){String} uid Google UID (required)
     * @apiParam (body){String} gg_token Google token string
     *
     * @apiParamExample Request-Example:
     *     {
     *       "uid": "1111111111111111111",
     *       "email":"nguyenptt@imt-soft.com",
     *       "gg_token":"BC3424DFDFDDSDBC3424DFDFDDSDBC3424DFDFDDSDBC3424DFDFDDSD"
     *     }
     *
     * @apiSuccessExample Success Response
     *       HTTP/1.1 200 OK
     *       {
     *          "success" : true,
     *          "data":{
     *             "token":"0x2E49Cff4906d8f4890fb08E287f6179781F6165C",
     *             "name":"Nguyen Phan",
     *             "email":"nguyenptt@imt-soft.com",
     *             "id":1
     *           }
     *        }
     *
     * @apiSuccessExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "success": false
     *       "error_code": "USER05"
     *       "message": "Error, please check you params"
     *     }
     */
    public function googleAuthenticate(Request $request){
        try{
            $validators = Validator::make($request->all(), [
                'email' => 'required|string|email',
                'uid' => 'required|string',
                'gg_token' => 'required|string'
            ]);

            if($validators->fails()){
                return response()->json([
                    "success" => false,
                    "error_code" => "USER05",
                    "message" => $validators->messages()
                ], 401);
            }

            $ggToken = $request->get('gg_token');
            if(!$ggToken){
                return response()->json([
                    "success" => false,
                    "error_code" => "USER05",
                    "message" => "Token invalid"
                ]);
            }

            $client = new Client();
            $res = $client->request('GET', 'https://www.googleapis.com/oauth2/v3/userinfo?access_token='.$ggToken);
            $body = json_decode($res->getBody(),true);
            if(!empty($body['error'])){
                return response()->json([
                    "success" => false,
                    "error_code" => "USER05",
                    "message" => "Unauthorized"
                ]);
            }

            $user = User::where('google_uid', $body['sub'])->orWhere('email',$body['email'])->first();

            if(!$user){
                $user = User::create([
                    'email' => $body['email'],
                    'gg_token' => $ggToken,
                    'google_uid' => $body['sub'],
                    'full_name' => $body['name'],
                ]);
            }
            $user->device_token = $request->input('device_token');
            $user->save();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->expires_at = Carbon::now()->addWeeks(1);

            $data = [
                'id' => $user->id,
                'gender' => $user->gender,
                'phone' => $user->phone,
                'token' => $tokenResult->accessToken,
                'name' => $body['name'],
                'email' => $body['email']
            ];

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\GuzzleHttp\Exception\ClientException $exception){
            return response()->json([
                "success" => false,
                "error_code" => "USER05",
                "message" => $exception->getMessage()
            ]);
        }catch (\Exception $exception){
            return response()->json([
                "success" => false,
                "error_code" => "USER05",
                "message" => $exception->getMessage()
            ]);
        }
    }

    /**
     * @api {POST} /api/fb-authenticate Authenticate by Facebook
     * @apiName Authenticate by Facebook
     * @apiVersion 1.0.0
     * @apiDescription Facebook Authenticate
     * @apiGroup AUTHENTICATE
     * @apiHeader {String} CLI-HEADER The key to access API server
     * @apiHeader {String} LANGUAGE Language Code
     *
     * @apiParam (body){String} [email] Facebook email.
     * @apiParam (body){String} uid Facebook UID (required)
     * @apiParam (body){String} fb_token Facebook token string - this will get from Facebook Oauth (required)
     *
     * @apiParamExample Request-Example:
     *     {
     *       "uid": "1111111111111111111",
     *       "email": "nguyenptt@imt-soft.com",
     *       "fb_token": "BC3424DFDFDDSDBC3424DFDFDDSDBC3424DFDFDDSDBC3424DFDFDDSD"
     *     }
     *
     * @apiSuccessExample Success Response
     *       HTTP/1.1 200 OK
     *       {
     *          "success": true,
     *          "data": {
     *             "id":1
     *             "token": "0x2E49Cff4906d8f4890fb08E287f6179781F6165C",
     *             "name": "Nguyen Phan",
     *             "email": "nguyenptt@imt-soft.com",
     *          }
     *        }
     *
     * @apiSuccessExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "success": false
     *       "error_code": "USER06"
     *       "message": "Error, please check you params"
     *     }
     */
    public function facebookAuthenticate(Request $request){
        try{
            $validators = Validator::make($request->all(), [
                'uid' => 'required|string',
                'fb_token' => 'required|string'
            ]);

            if($validators->fails()){
                return response()->json([
                    "success" => false,
                    "error_code" => "USER06",
                    "message" => $validators->messages()
                ], 401);
            }

            $fbToken = $request->get('fb_token');

            $client = new Client();
            $res = $client->request('GET', 'https://graph.facebook.com/me?fields=id,email,name&access_token='.$fbToken);
            $body = json_decode($res->getBody(),true);
            if(!empty($body['error'])){
                return response()->json([
                    "success" => false,
                    "error_code" => "USER06",
                    "message" => "Unauthorized"
                ]);
            }

            $user = User::where('fb_uid', $body['id'])->orWhere('email',$body['email'])->first();

            if(!$user){
                $user = User::create([
                    'email' => $body['email'],
                    'fb_token' => $fbToken,
                    'fb_uid' => $body['id'],
                    'full_name' => $body['name'],
                ]);
            }
            $user->device_token = $request->input('device_token');
            $user->save();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->expires_at = Carbon::now()->addWeeks(1);

            $data = [
                'id' => $user->id,
                'gender' => $user->gender,
                'phone' => $user->phone,
                'token' => $tokenResult->accessToken,
                'name' => $body['name'],
                'email' => $body['email']
            ];

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\GuzzleHttp\Exception\ClientException $exception){
            return response()->json([
                "success" => false,
                "error_code" => "USER06",
                "message" => $exception->getMessage()
            ]);
        }catch (\Exception $exception){
            return response()->json([
                "success" => false,
                "error_code" => "USER06",
                "message" => $exception->getMessage()
            ]);
        }
    }

    public function verify(Request $request){
        $user = $request->user();
        return response()->json([
            'success'=> true,
            "data" => [
                'id' => $user->id,
                'name' => $user->full_name,
                'email' => $user->email,
                'gender' => $user->gender,
                'phone' => $user->phone,
            ]
        ]);
    }

    public function logout(Request $request){
      $user = $request->user();
      $user->device_token = null;
      $user->save();
      $user = DB::table('oauth_access_tokens')->where('user_id','=',$user->id)->delete();
      return response()->json([
        'success' => true,
        'message' => 'Logout successfully'
      ]);
    }
}
