<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with('category');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);

        $wishlistProductIds = [];
        if (Auth::check()) {
            $wishlistProductIds = Auth::user()->wishlistProducts()->pluck('products.id')->toArray();
        }

        return view('products', compact('products', 'wishlistProductIds'));
    }

    public function show(Product $product)
    {
        $product->load('category');

        // AMBIL STATUS WISHLIST (Untuk Halaman Detail)
        // Agar saat masuk detail, tombolnya tahu harus merah atau putih
        $isWishlist = false;
        if (Auth::check()) {
            $isWishlist = Auth::user()->wishlistProducts()->where('product_id', $product->id)->exists();
        }

        return view('product-detail', [
            'title' => 'Detail Produk',
            'product' => $product,
            'isWishlist' => $isWishlist // Kirim variabel ini ke view
        ]);
    }
}
