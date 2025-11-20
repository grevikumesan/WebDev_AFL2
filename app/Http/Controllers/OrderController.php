<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    // Menampilkan daftar pesanan user
    public function index()
    {
        $orders = Order::with('items.product')
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->get();

        return view('orders.index', compact('orders'));
    }

    // Proses Upload Bukti Pembayaran
    public function uploadProof(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if ($request->hasFile('payment_proof')) {
            // Hapus bukti lama jika ada (misal user salah upload sebelumnya)
            if ($order->payment_proof) {
                Storage::disk('public')->delete($order->payment_proof);
            }

            // Simpan gambar ke folder 'payment-proofs' di storage public
            $path = $request->file('payment_proof')->store('payment-proofs', 'public');

            // Update data order
            $order->update([
                'payment_proof' => $path,
                'status' => 'pending'
            ]);
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload! Mohon tunggu konfirmasi Admin.');
    }
}
