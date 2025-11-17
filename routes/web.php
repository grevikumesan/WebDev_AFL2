<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController; 
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;

//PUBLIK
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

//nampilin produk
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('products.show');


//AUTHENTICATION (Login, Register, dll)
Auth::routes();


//CUSTOMER
Route::middleware(['auth'])->group(function () {

    //profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    //cart
    //nampilin halaman cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    //nambah item ke cart (dari form)
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    //update quantity item di cart
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    //hapus item dari cart
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    //wishlist
    //nampilin halaman wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    //nambah item ke wishlist (dari form)
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
    //hapus item dari wishlist
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

});

//ADMIN
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    //crud user
    Route::resource('users', UserController::class);
});
