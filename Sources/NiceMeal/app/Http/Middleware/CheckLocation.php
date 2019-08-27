<?php

namespace App\Http\Middleware;

use Closure,Session;
use App\Models\Restaurant;

class CheckLocation
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
        if($request->input('district') == null){
            Session::flash("flash_error","Please choose district");
            return redirect('/');
        }
        return $next($request);
    }

    public function synchronizeCartData($cart){

    }   
}
