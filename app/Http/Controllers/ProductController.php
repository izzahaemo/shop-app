<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;


class ProductController extends Controller
{
    public function index()
    {
        if(!Auth::user()->hasPermission('product-read'))
        {
            return Redirect::route('home');
        }
        $categories = Category::all();
        $products = Product::latest()->paginate(10);
        return view('admin.product', compact('products','categories'));
    }

    public function create(Request $request)
    {
        if(!Auth::user()->hasPermission('product-create'))
        {
            return Redirect::route('home');
        }

        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'desc' => 'required',
        ]);

        if($request->file('file'))
        {
            $file = $request->file('file');
            $path = time() . '_' . $request->name  .  '.' . $file->getClientOriginalExtension();
            Storage::disk('local')->put('public/products/'. $path, file_get_contents($file));
        } else 
        {
            $path = 'default.jpg';
        }

        Product::create([
            'name'=> $request->name,
            'price'=> $request->price,
            'desc'=> $request->desc,
            'img'=> $path,
            'category_id'=> $request->category_id,
        ]);

        return Redirect::route('product_admin');
    }

    public function update(Request $request, Product $product)
    {
        if(!Auth::user()->hasPermission('product-update'))
        {
            return Redirect::route('home');
        }

        $path = $product->img;

        if($request->file('file'))
        {
            if($path != 'default.jpg')
            {
                Storage::delete('public/watch/'. $product->img);
            }
            $file = $request->file('file');
            $path = time() . '_' . $request->name  .  '.' . $file->getClientOriginalExtension();
            Storage::disk('local')->put('public/products/'. $path, file_get_contents($file));
        }

        $product->update([
            'name'=> $request->name,
            'price'=> $request->price,
            'desc'=> $request->desc,
            'img'=> $path,
            'category_id'=> $request->category_id,
        ]);

        return Redirect::route('product_admin');
    }

    public function delete(Product $product)
    {
        if(!Auth::user()->hasPermission('product-delete'))
        {
            return Redirect::route('home');
        }

        if($product->img != 'default.jpg')
        {
            Storage::delete('public/products/'. $product->img  );
        }
        $product->delete();
        return Redirect::route('product_admin');
    }

    public function category()
    {
        if(!Auth::user()->hasPermission('category-read'))
        {
            return Redirect::route('home');
        }
        $categories = Category::all();


        foreach($categories as $category)
        {
            $id = $category->id;
            $products = Product::where('category_id', '=', $id)->get();
            $category['count'] = count($products);
        }

        return view('admin.category', compact('categories'));
    }

    public function category_create(Request $request)
    {
        if(!Auth::user()->hasPermission('category-create'))
        {
            return Redirect::route('home');
        }

        $request->validate([
            'name' => 'required',
        ]);

        Category::create([
            'name'=> $request->name,
        ]);

        return Redirect::route('category_admin');
    }

    public function category_update(Request $request, Category $category)
    {
        if(!Auth::user()->hasPermission('category-update'))
        {
            return Redirect::route('home');
        }

        $category->update([
            'name'=> $request->name,
        ]);

        return Redirect::route('category_admin');
    }

    public function category_delete(Category $category)
    {
        if(!Auth::user()->hasPermission('category-delete'))
        {
            return Redirect::route('home');
        }

        $category->delete();
        return Redirect::route('category_admin');
    }
}
