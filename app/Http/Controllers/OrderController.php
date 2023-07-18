<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        if(!Auth::user()->hasPermission('order-read'))
        {
            return Redirect::route('home');
        }
        $categories = Category::all();
        $user_id = Auth::id();
        $orders = Order::where('user_id', $user_id)->get();
        return view('home.order', compact('orders','categories'));
    }

    public function create(Request $request)
    {
        if(!Auth::user()->hasPermission('order-create'))
        {
            return Redirect::route('home');
        }

        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ]);

        $user_id = Auth::id();

        $carts = Cart::where('user_id', $user_id)->get();

        $product = [];
        $product_id = 0;
        
        foreach($carts as $cart)
        {
            $product[$product_id]['name'] = $cart->product->name;
            $product[$product_id]['price'] = $cart->product->price;
            $product_id++;
        }
        $productJson = json_encode($product);

        Order::create([
            'name'=> $request->name,
            'address'=> $request->address,
            'phone'=> $request->phone,
            'gross_amount'=> $request->gross_amount,
            'user_id'=> $user_id,
            'products' => $productJson 
        ]);

        return Redirect::route('cart');
    }
}
