<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('cart.index', compact('cartItems'));
    }

    public function store(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        $productId = $request->product_id;
        $quantity = $request->quantity;

        $existingCartItem = Cart::where('user_id', $userId)
                                ->where('product_id', $productId)
                                ->first();

        if ($existingCartItem) {
            $existingCartItem->quantity += $quantity;
            $existingCartItem->save();
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        // RESPON JSON UNTUK AJAX
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Produk berhasil masuk keranjang!'
            ]);
        }

        return back()->with('success', 'Produk berhasil masuk keranjang!');
    }

    public function update(Request $request, Cart $cart) {
        if ($cart->user_id !== Auth::id()) abort(403);
        $request->validate(['quantity' => 'required|integer|min:1']);
        $cart->update(['quantity' => $request->quantity]);
        return redirect()->route('cart.index')->with('success', 'Jumlah diupdate.');
    }

    public function destroy(Cart $cart) {
        if ($cart->user_id !== Auth::id()) abort(403);
        $cart->delete();
        return redirect()->route('cart.index')->with('success', 'Dihapus dari keranjang.');
    }
}
