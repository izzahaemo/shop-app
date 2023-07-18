<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Category;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if(!Auth::user()->hasPermission('cart-read'))
        {
            return Redirect::route('home');
        }
        $categories = Category::all();
        $user_id = Auth::id();
        $carts = Cart::where('user_id', $user_id)->get();
        $total = null;
        foreach ($carts as $cart)
        {
            $total = $total + ($cart->product->price * $cart->amount);
        }
        return view('home.cart', compact('carts','categories','total'));
    }

    public function add(Request $request, Product $product)
    {
        if(!Auth::user()->hasPermission('cart-create'))
        {
            return Redirect::route('home');
        }
        $user_id = Auth::id();
        $product_id = $product->id;

        $existing_cart = Cart::where('product_id', $product_id)
            ->where('user_id', $user_id)
            ->first();

        if($existing_cart == null)
        {
            $request->validate([
                'amount' => 'required'
            ]);

            Cart::create([
                'user_id' => $user_id,
                'product_id' => $product_id,
                'amount' => $request->amount
            ]);
        }
        else
        {
            $request->validate([
                'amount' => 'required'
            ]);

            $existing_cart->update([
                'amount' => $existing_cart->amount + $request->amount
            ]);
        }

        return Redirect::route('cart');
    }

    public function update(Request $request, Cart $cart)
    {
        if(!Auth::user()->hasPermission('cart-update'))
        {
            return Redirect::route('home');
        }
        $request->validate([
            'amount' => 'required'
        ]);

        $cart->update([
            'amount' => $request->amount
        ]);

        return Redirect::route('cart');
    }

    public function delete(Cart $cart)
    {
        if(!Auth::user()->hasPermission('cart-delete'))
        {
            return Redirect::route('home');
        }
        $cart->delete();
        return Redirect::back();
    }
}
