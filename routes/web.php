<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/category/{category}', [HomeController::class, 'category'])->name('category');
Route::get('/product/{product}', [HomeController::class, 'product'])->name('product');



Route::middleware('auth')->group( function () {
    Route::get('/product_admin', [ProductController::class, 'index'])->name('product_admin');
    Route::post('/product_create' , [ProductController::class, 'create'])->name('product_create');
    Route::patch('/product_update/{product}' , [ProductController::class, 'update'])->name('product_update');
    Route::delete('/product_delete/{product}' , [ProductController::class, 'delete'])->name('product_delete');
    
    Route::get('/cart' , [CartController::class, 'index'])->name('cart');
    Route::post('/cart_add/{product}' , [CartController::class, 'add'])->name('cart_add');
    Route::patch('/cart_update/{cart}' , [CartController::class, 'update'])->name('cart_update');
    Route::delete('/cart_delete/{cart}' , [CartController::class, 'delete'])->name('cart_delete');
    
    Route::get('/order' , [OrderController::class, 'index'])->name('order');
    Route::post('/order_create' , [OrderController::class, 'create'])->name('order_create');
    Route::patch('/order_update/{order}' , [OrderController::class, 'update'])->name('order_update');
    Route::delete('/order_delete/{order}' , [OrderController::class, 'delete'])->name('order_delete');
    Route::get('/checkout/{order}' , [OrderController::class, 'checkout'])->name('checkout');
});