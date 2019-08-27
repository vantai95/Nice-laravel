<?php

namespace App\Http\Middleware;

use Closure;

class CheckHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->header('CLI-HEADER') == null){
            return response()->json(array('error'=>'Please enter CLI-Header'));
        }

        if($request->header('LANGUAGE') == null){
            return response()->json(array('error'=>'Please enter Language Code'));
        }

        if($request->header('CLI-HEADER') != env('CLI-HEADER')){
            return response()->json(array('error'=>'Invalid CLI-Header, please check again'));
        }
        $lang = explode(',',env('LANGUAGE'));
        
        if(!in_array($request->header('LANGUAGE'),$lang)){
            return response()->json(array('error'=>'Invalid Lang code, please check again'));
        }

        return $next($request);
    }
}
