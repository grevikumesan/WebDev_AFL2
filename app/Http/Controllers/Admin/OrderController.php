<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        // Ambil semua pesanan, urutkan yang 'pending' (butuh aksi) ditaruh paling atas
        $orders = Order::with('user')
            ->orderByRaw("FIELD(status, 'pending', 'paid', 'unpaid', 'completed', 'cancelled')")
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:paid,completed,cancelled,unpaid',
        ]);

        // Kita butuh data items dan product untuk update stok
        $order = Order::with('items.product')->findOrFail($id);

        $oldStatus = $order->status; // Status sebelum diupdate
        $newStatus = $request->status; // Status baru yang dipilih admin

        // --- LOGIKA PENGURANGAN STOK ---

        // 1. Jika status berubah jadi 'paid' (Pembayaran Diterima)
        // Dan sebelumnya belum 'paid'/'completed' (Supaya tidak kepotong 2x kalau diklik berkali-kali)
        if ($newStatus == 'paid' && !in_array($oldStatus, ['paid', 'completed'])) {
            foreach ($order->items as $item) {
                // Kurangi stok produk
                $item->product->decrement('stock', $item->quantity);
            }
        }

        // 2. (Opsional) Jika pesanan DIBATALKAN setelah sempat dibayar (kembalikan stok)
        if ($newStatus == 'cancelled' && in_array($oldStatus, ['paid', 'completed'])) {
            foreach ($order->items as $item) {
                // Kembalikan stok produk
                $item->product->increment('stock', $item->quantity);
            }
        }
        // -------------------------------

        $order->update(['status' => $newStatus]);

        return redirect()->back()->with('success', 'Status pesanan diperbarui & stok disesuaikan.');
    }
}
