<?php

namespace App\Http\Controllers\Api;

use App\Services\CommonService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App, DB;

class PaymentController extends Controller
{


    /**
     * @api {GET} /api/order/encrypt-data encryptData
     * @apiName encryptData
     * @apiVersion 1.0.0
     * @apiDescription encryptData to send Alepay
     * @apiGroup ORDER
     *
     * @apiParam {String} $data
     *
     * @apiParamExample Request-Example:
     *     {
     *       "data": 1
     *     }
     *
     * @apiSuccessExample Success Response
     *       HTTP/1.1 200 OK
     *       {
     *          "success" : true,
     *        }
     *
     * @apiSuccessExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "success" : false
     *       "error_code": "ExampleC0de"
     *       "message": "Error, please check you params"
     *     }
     */
    public function encryptData(Request $request) {
         
        require(app_path() . '\Libraries\Alepay.php');
        try { 
            $alepayConf = \Config::get('nganluong');  
            $alepay = new \Alepay($alepayConf);  
            $data = isset($request['data'])?$request['data']:'';
            $encryptDataAlepay = $alepay->encryptCallBackData($data);
            
            return response()->json([
                'success' => true,
                'data' => $encryptDataAlepay
            ]);
            
        }
        catch(\Exception $exception) {
            \Log::error($exception);
            return response()->json([
                "success" => false,
                "error_code" => "ALEPAY00",
                "message" => "Error, please check you params"
            ]);
        }
    }
    /**
     * @api {GET} /api/order/decrypt-data decryptData
     * @apiName decrypt
     * @apiVersion 1.0.0
     * @apiDescription decryptData to send Alepay
     * @apiGroup ORDER
     *
     * @apiParam {String} $data
     *
     * @apiParamExample Request-Example:
     *     {
     *       "data": 1
     *     }
     *
     * @apiSuccessExample Success Response
     *       HTTP/1.1 200 OK
     *       {
     *          "success" : true,
     *        }
     *
     * @apiSuccessExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "success" : false
     *       "error_code": "ExampleC0de"
     *       "message": "Error, please check you params"
     *     }
     */
    public function decryptData(Request $request){
        require(app_path() . '\Libraries\Alepay.php');
        try { 
            $alepayConf = \Config::get('nganluong');  
            $alepay = new \Alepay($alepayConf);  
            $data = isset($request['data'])?$request['data']:'';
            $decryptDataAlepay = $alepay->decryptCallbackData($data);
            
            return response()->json([
                'success' => true,
                'data' => $decryptDataAlepay
            ]);
            
        }
        catch(\Exception $exception) {
            \Log::error($exception);
            return response()->json([
                "success" => false,
                "error_code" => "ALEPAY00",
                "message" => "Error, please check you params"
            ]);
        }
    }
}
