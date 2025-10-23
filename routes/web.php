<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;


//route yang memberi tahu Laravel
//ketika user mengunjungi URL, menggunakan metode GET
//jalankan function bernama index yang ada di dalam file HomeController.class
// Home routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/contact', [HomeController::class, 'contact']);
Route::get('/cart', [HomeController::class, 'cart']);
Route::get('/wishlist', [HomeController::class, 'wishlist']);

// Product routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
