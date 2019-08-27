<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\Services\CartService;

class CartCheck
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
        if(!Session::get('cart')){
            $cart = CartService::initCart();
            Session::put('cart',collect($cart));
        }
        return $next($request);
    }
}
