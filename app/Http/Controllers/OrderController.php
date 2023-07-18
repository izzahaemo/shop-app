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
            $product[$product_id]['amount'] = $cart->amount;
            $product_id++;
        }
        Cart::where('user_id', $user_id)->delete();
        $productJson = json_encode($product);

        Order::create([
            'name'=> $request->name,
            'address'=> $request->address,
            'phone'=> $request->phone,
            'gross_amount'=> $request->gross_amount,
            'user_id'=> $user_id,
            'products' => $productJson 
        ]);

        return Redirect::route('order');
    }
    
    public function update(Request $request, Order $order)
    {
        if(!Auth::user()->hasPermission('order-update'))
        {
            return Redirect::route('home');
        }

        $request->validate([
            'track' => 'required',
        ]);

        $order->update([
            'status' => 'Shipped',
            'track' => $request->track
        ]);


        return Redirect::route('order');
    }

    public function delete(Order $order)
    {
        if(!Auth::user()->hasPermission('order-delete'))
        {
            return Redirect::route('home');
        }

        $order->delete();
        return Redirect::route('order');
    }

    public function checkout(Order $order)
    {
        $categories = Category::all();
        $products = json_decode($order->products);
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        
        $params = array(
            'transaction_details' => array(
                'order_id' => $order->id,
                'gross_amount' => $order->gross_amount,
            ),
            'customer_details' => array(
                'first_name' => $order->name,
                'last_name' => '',
                'phone' => $order->phone,
            ),
        );
        

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        return view('home.checkout', compact('snapToken', 'order','categories','products'));
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if($hashed == $request->signature_key){
            if($request->transaction_status == 'capture' or $request->transaction_status == 'settlement'){
                $order = Order::find($request->order_id);
                $order->update(['status' => 'Paid']);
            }
        }
    }
}
