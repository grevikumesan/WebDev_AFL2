<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller {

    public function index(Request $request) {
        $query = Product::with('category');

        // nampilin semua produk yang mirip dengan hasil input search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        // filter kategori
        if ($request->has('kategori')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->input('kategori'));
            });
        }

        $products = $query->paginate(15);

        return view('products', [
            'title' => 'Daftar Produk',
            'products' => $products
        ]);
    }

    public function show(Product $product) {
        $product->load('category'); 
        return view('product-detail', [
            'title' => 'Detail Produk',
            'product' => $product
        ]);
    }
}
