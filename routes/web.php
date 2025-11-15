<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController; // <-- DITAMBAHKAN: Diperlukan untuk rute cart.add
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Kita bagi rute jadi 4 grup:
| 1. Rute Publik: Bisa diakses siapa aja.
| 2. Rute Auth: Bawaan laravel/ui (login, register).
| 3. Rute Customer: HANYA untuk user yang sudah login.
| 4. Rute Admin: HANYA untuk user yang login DAN role-nya 'admin'.
|
*/

// --- GRUP 1: RUTE PUBLIK (Bisa diakses Guest & User) ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Rute buat nampilin produk
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('products.show');


// --- GRUP 2: RUTE OTENTIKASI (Login, Register, dll) ---
// Bawaan dari laravel/ui
Auth::routes();


// --- GRUP 3: RUTE CUSTOMER (WAJIB LOGIN) ---
// "Satpam" 'auth' bawaan Laravel akan ngejaga grup ini.
// Rute /cart dan /wishlist dipindah ke sini biar aman.
Route::middleware(['auth'])->group(function () {

    Route::get('/cart', [HomeController::class, 'cart'])->name('cart.index');
    
    // RUTE BARU DITAMBAHKAN: Untuk memproses form 'Tambah ke Keranjang'
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add'); 

    Route::get('/wishlist', [HomeController::class, 'wishlist'])->name('wishlist.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/cart/add', [HomeController::class, 'addToCart'])->name('cart.add');

    // Nanti taruh rute 'profile', 'checkout', 'tambah ke cart' di sini

});

// --- GRUP 4: RUTE ADMIN (WAJIB LOGIN & ROLE ADMIN) ---
// Ini grup paling aman, dijaga 2 "Satpam": 'auth' dan 'admin'
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Rute buat CRUD User (admin.users.index, admin.users.create, dll)
    Route::resource('users', UserController::class);

    // Nanti tambahin rute dashboard admin, dll di sini
    // Contoh: Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

});