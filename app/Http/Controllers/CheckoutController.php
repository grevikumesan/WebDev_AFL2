<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Menampilkan halaman form checkout
    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong!');
        }

        return view('checkout.index', compact('cartItems'));
    }

    // Proses simpan pesanan & redirect WA
    public function store(Request $request)
    {
        $request->validate([
            'receiver_name' => 'required|string|max:255',
            'receiver_phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        // 1. Ambil data keranjang
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock) {
                return redirect()->route('cart.index')
                    ->with('error', 'Stok produk ' . $item->product->name . ' tidak mencukupi. Sisa stok: ' . $item->product->stock);
            }
        }

        // 2. Hitung total
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Gunakan Transaction biar kalau error data tidak masuk setengah-setengah
        DB::transaction(function () use ($request, $cartItems, $totalPrice) {
            // Simpan Order (Status Unpaid)
            $order = Order::create([
                'user_id' => Auth::id(),
                'receiver_name' => $request->receiver_name,
                'receiver_phone' => $request->receiver_phone,
                'address' => $request->address,
                'notes' => $request->notes,
                'total_price' => $totalPrice,
                'status' => 'unpaid',
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                // CATATAN: Kita TIDAK mengurangi stok di sini.
                // Stok dikurangi saat Admin memvalidasi pembayaran.
            }

            Cart::where('user_id', Auth::id())->delete();
        });

        // 6. FORMAT PESAN WHATSAPP
        // Ganti nomor ini dengan nomor admin kamu (format 628xxx)
        $adminPhone = '6285655502666';

        $message = "Halo Admin, saya mau pesan:\n\n";
        foreach ($cartItems as $item) {
            $message .= "- {$item->product->name} ({$item->quantity}x) \n";
        }
        $message .= "\nTotal: Rp " . number_format($totalPrice, 0, ',', '.');
        $message .= "\n\nDetail Pengiriman:";
        $message .= "\nNama: " . $request->receiver_name;
        $message .= "\nAlamat: " . $request->address;
        if ($request->notes) {
            $message .= "\nCatatan: " . $request->notes;
        }

        // Encode text agar aman di URL
        $url = "https://wa.me/{$adminPhone}?text=" . urlencode($message);

        // Redirect ke WhatsApp
        return redirect()->away($url);
    }
}
