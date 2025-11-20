<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Total Pendapatan (Hanya yang status paid/completed)
        $totalRevenue = Order::whereIn('status', ['paid', 'completed'])->sum('total_price');

        // 2. Hitung Pesanan Pending (Butuh aksi admin segera)
        $pendingOrders = Order::where('status', 'pending')->count();

        // 3. Hitung Total Produk
        $totalProducts = Product::count();

        // 4. Hitung Total Customer
        $totalCustomers = User::where('role', 'customer')->count();

        // 5. Ambil 5 Pesanan Terbaru (Buat tabel mini)
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'pendingOrders',
            'totalProducts',
            'totalCustomers',
            'recentOrders'
        ));
    }
}
