<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class WishlistController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $wishlistItems = Auth::user()->wishlistProducts()->with('category')->get();
        return view('wishlist.index', compact('wishlistItems'));
    }

    public function store(Request $request)
    {
        // 1. Validasi sederhana
        if (!$request->product_id) {
            return response()->json(['status' => 'error', 'message' => 'ID Produk tidak valid'], 400);
        }

        try {
            $user = Auth::user();
            $productId = $request->product_id;

            // 2. Gunakan toggle() dan tangkap hasilnya
            // toggle mengembalikan array: ['attached' => [...], 'detached' => [...]]
            $changes = $user->wishlistProducts()->toggle($productId);

            // 3. Cek apa yang terjadi
            $isAdded = count($changes['attached']) > 0;
            $action = $isAdded ? 'added' : 'removed';
            $message = $isAdded ? 'Berhasil ditambahkan ke wishlist!' : 'Dihapus dari wishlist.';

            // 4. Return JSON Pasti
            return response()->json([
                'status' => 'success',
                'action' => $action,
                'message' => $message,
                'product_id' => $productId // Kirim balik ID untuk verifikasi di JS
            ]);

        } catch (\Exception $e) {
            // Log error di server (storage/logs/laravel.log)
            Log::error('Wishlist Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan server.'
            ], 500);
        }
    }
}
