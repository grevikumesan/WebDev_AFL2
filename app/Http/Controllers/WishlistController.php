<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class WishlistController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $wishlistItems = Auth::user()->wishlistProducts()->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = Auth::user();
        $productId = $request->product_id;

        if (!$user->wishlistProducts()->where('product_id', $productId)->exists()) {
            $user->wishlistProducts()->attach($productId);
            return back()->with('success', 'Produk ditambahkan ke wishlist!');
        }

        if ($request->wantsJson()) {
            return response()->json(['status' => 'info', 'message' => 'Produk ini sudah ada di wishlist.']);
        }

        return back()->with('info', 'Produk ini sudah ada di wishlist.');
    }

    public function destroy(Product $product)
    {
        Auth::user()->wishlistProducts()->detach($product->id);

        return back()->with('success', 'Produk dihapus dari wishlist.');
    }
}
