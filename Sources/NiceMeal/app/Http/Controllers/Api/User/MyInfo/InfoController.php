<?php

namespace App\Http\Controllers\Api\User\MyInfo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserCustomerInfo;
use Validator;

class InfoController extends Controller
{
    /**
     * @api {GET} /api/my-contact-info Get My Contact Info
     * @apiName Get My Contact Info
     * @apiVersion 1.0.0
     * @apiDescription Get My Contact Info
     * @apiGroup MY INFO
     * @apiHeader {String} CLI-HEADER The key to access API server
     * @apiHeader {String} LANGUAGE Language Code
     * @apiHeader {String} Authorization Access Token
     * @apiSuccessExample Success Response
     *       HTTP/1.1 200 OK
     *       {
     *          "success": true,
     *          "main_info": {
     *               "email": "admin@mailinator.com",
     *               "full_name": "Mannnn",
     *               "birth_day": "1997-01-31",
     *               "address": "321321 dsadsad DSADAS",
     *               "phone": "0993555777"
     *          },
     *          "extra_info": [
     *           {
     *               "id": 27,
     *               "user_id": 1,
     *               "address": "dsadasdsa",
     *               "email": "mantm3101.1@gmail.com",
     *               "phone": "906448224",
     *           },
     *       }
     *
     * @apiSuccessExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "success": false
     *       "error_code": "USER01"
     *       "message": "Error, please check you params"
     *     }
     */
    public function myInfo(Request $request){
        $user = $request->user();
        $main_info = [
            'email' => $user->email,
            'full_name' => $user->full_name,
            'birth_day' => $user->birth_day,
            'address' => $user->address,
            'full_name' => $user->full_name,
            'phone' => $user->phone
        ];
        $extra_info = [];

        $extra_info = UserCustomerInfo::select('id','email','phone','address')->where('user_id','=',$user->id)->get()->toArray();
        return response()->json([
            'success' => true,
            'main_info' => $main_info,
            'extra_info' => $extra_info
        ]);
    }

    public function updateMainInfo(Request $request)
    {
        $requestData = $request->all();

        $validators = Validator::make($requestData, [
            'full_name' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            //'phone' => 'required|min:10|max:11|regex:/^[0-9]+$/',
            'phone' => 'required|min:8|regex:/^[0-9]+$/',
        ]);
        if($validators->fails()){
            return response()->json([
                "success" => false,
                "error_code" => "USER02",
                "message" => $validators->messages()
            ], 401);
        }

        $user = $request->user();

        if($request->post('full_name') !== null){
            $user->full_name = $request->post('full_name');
        }

        if($request->post('birth_day') !== null){
            $user->birth_day = $request->post('birth_day');
        }
        
        if($request->post('phone') !== null){
            $user->phone = $request->post('phone');
        }

        if($request->post('address') !== null){
            $user->address = $request->post('address');
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => "Main Info Updated"
        ]);
    }

    /**
     * @api {GET} /api/update-my-contact-info/:info_id Update My Contact Info
     * @apiName Update My Contact Info
     * @apiVersion 1.0.0
     * @apiDescription Update My Contact Info
     * @apiGroup MY INFO
     * @apiHeader {String} CLI-HEADER The key to access API server
     * @apiHeader {String} LANGUAGE Language Code
     * @apiHeader {String} Authorization Access Token
     * @apiSuccessExample Success Response
     *       HTTP/1.1 200 OK
     *       {
     *          "success": true,
     *          "message": "Info Updated"
     *       }
     *
     * @apiErrorExample Validatefail:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "success": false,
     *       "error_code": "USER01",
     *       "message": {
     *          "email": [
     *               "The email must be a valid email address."
     *           ],
     *           "phone": [
     *               "The phone must be a number."
     *           ]
     *       }
     *     }
     */
    public function updateInfo(Request $request, $id){
        $user = $request->user();
        $requestData = $request->all();

        $validators = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'phone' => 'required|numeric',
            'address' => 'required|string',
        ]);

        if($validators->fails()){
            return response()->json([
                "success" => false,
                "error_code" => "USER01",
                "message" => $validators->messages()
            ], 401);
        }

        $info = UserCustomerInfo::where('user_id','=',$user->id)->where('id','=',$id)->first();
        if($info == null){
            return response()->json([
                "success" => false,
                "error_code" => "USER01",
                "message" => "Info not found"
            ]);
        }

        try{
            $info->update($requestData);
        }catch(\Exception $exception){
            return response()->json([
                "success" => false,
                "error_code" => "USER01",
                "message" => "Update fail"
            ]);
        }
        return response()->json([
            "success" => true,
            "message" => "Info updated"
        ]);
    }

    /**
     * @api {GET} /api/create-my-contact-info Create My Contact Info
     * @apiName Create My Contact Info
     * @apiVersion 1.0.0
     * @apiDescription Create My Contact Info
     * @apiGroup MY INFO
     * @apiHeader {String} CLI-HEADER The key to access API server
     * @apiHeader {String} LANGUAGE Language Code
     * @apiHeader {String} Authorization Access Token
     * @apiSuccessExample Success Response
     *       HTTP/1.1 200 OK
     *       {
     *          "success": true,
     *          "message": "Info Updated"
     *       }
     *
     * @apiErrorExample Validatefail:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "success": false,
     *       "error_code": "USER01",
     *       "message": {
     *          "email": [
     *               "The email must be a valid email address."
     *           ],
     *           "phone": [
     *               "The phone must be a number."
     *           ]
     *       }
     *     }
     */
    public function addInfo(Request $request)
    {
        $user = $request->user();
        $requestData = $request->all();

        $validators = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'phone' => 'required|numeric',
            'address' => 'required|string',
        ]);

        if($validators->fails()){
            return response()->json([
                "success" => false,
                "error_code" => "USER01",
                "message" => $validators->messages()
            ], 401);
        }

        $requestData['user_id'] = $user->id;

        try{
            $alterProfile = UserCustomerInfo::create($requestData);
        }catch(\Exception $exception){
            return response()->json([
                "success" => false,
                "error_code" => "USER01",
                "message" => "Create info fail"
            ], 401);
        }

        return response()->json([
            "success" => true,
            "message" => "Info created"
        ]);
    }

    /**
     * @api {GET} /api/delete-my-contact-info/:info_id Delete My Contact Info
     * @apiName Delete My Contact Info
     * @apiVersion 1.0.0
     * @apiDescription Delete My Contact Info
     * @apiGroup MY INFO
     * @apiHeader {String} CLI-HEADER The key to access API server
     * @apiHeader {String} LANGUAGE Language Code
     * @apiHeader {String} Authorization Access Token
     * @apiSuccessExample Success Response
     *       HTTP/1.1 200 OK
     *       {
     *          "success": true,
     *          "message": "Info Updated"
     *       }
     *
     * @apiErrorExample Info not found:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "success": false,
     *       "error_code": "USER01",
     *       "message": "Info not found"
     *     }
     */
    public function deleteInfo(Request $request,$id){
        $user = $request->user();
        $info = UserCustomerInfo::where('user_id','=',$user->id)->where('id','=',$id)->first();
        if($info == null){
            return response()->json([
                "success" => false,
                "error_code" => "USER01",
                "message" => "Info not found"
            ]);
        }

        try{
            $info->delete();
        }
        catch(\Exception $exception){
            return response()->json([
                "success" => false,
                "error_code" => "USER01",
                "message" => "Delete fail"
            ]);
        }
        return response()->json([
            "success" => true,
            "message" => "Info deleted"
        ]);
    }
}
