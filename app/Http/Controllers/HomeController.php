<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::all();
        $products =  Product::inRandomOrder()->limit(6)->get();
        return view('home.home', compact('products','categories'));
    }

    public function products()
    {
        $category = null;
        $categories = Category::all();
        $products = Product::latest()->paginate(6);
        return view('home.products', compact('products','categories','category'));
    }

    public function category(Category $category)
    {
        $categories = Category::all();
        $products = Product::where('category_id', '=', $category->id)->paginate(6);;
        return view('home.products', compact('products','categories','category'));
    }

    public function product(Product $product)
    {
        $categories = Category::all();
        return view('home.product', compact('product','categories'));
    }
}
