<?php

namespace App\Http\Controllers\Api\User\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CartService;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $cart = $request->input('cart');
        $item = $request->input('item');
        try{
            $cart = CartService::doAdd($cart,$item);
        }catch(\Exception $exception){
            return response()->json([
                'success' => false,
                'message' => "Unknown error"
            ]);    
        }
        return response()->json([
            'success' => true,
            'data'=>$cart
        ]);
    }

    public function subtractFromCart(Request $request){
        $cart = $request->input('cart');
        $index = $request->input('index');
        array_splice($cart['items'],$index,1);
        try{
            $cart = CartService::updateCartInfo($cart);
        }catch(\Exception $exception){
            return response()->json([
                'success' => false,
                'message' => "Unknown error"
            ]);    
        }
        return response()->json([
            'success' => true,
            'data'=>$cart
        ]);
    }

    public function dishAmountChange(Request $request){
        $cart = $request->input('cart');
        $index = $request->input('index');
        $quantity = $request->input('quantity');
        if(!$quantity || $quantity <= 0){
            $cart['items'][$index]['quantity'] = 1;    
        }else{
            $cart['items'][$index]['quantity'] = $quantity;
        }

        $cart = CartService::updateCartInfo($cart);

        return response()->json([
            'success' => true,
            'data'=>$cart
        ]);
    }

    public function updateCart(Request $request){
        $cart = $request->post('cart');
        $cart = CartService::updateCartInfo($cart);
        return response()->json([
            'success' => true,
            'data'=>$cart
        ]);
    }
}
