<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index() {
        return view('home', ['title' => 'Home']);
    }

    public function about() {
        return view('about', [
            'title' => 'Tentang Kami',
            'description' => 'Toko Wilujeng adalah toko sembako yang berlokasi di Jln. Raya Perning,
                                Kabupaten Mojokerto yang telah menjadi pilihan utama masyarakat sekitar
                                dalam memenuhi kebutuhan pokok sehari-hari. Toko Wilujeng menyediakan
                                berbagai produk sembako seperti gula, tepung, rokok, dan masih banyak lagi.'
        ]);
    }

    public function contact() {
        return view('contact', [
            'title' => 'Kontak Kami',
            'phone' => '0856-5507-8878 - Fenny',
            'address' => 'Jl. Raya Perning No. 358, Kec. Jetis, Kabupaten Mojokerto', //diisi
            'jamBuka' => 'Senin-Jumat : 08.00 - 17.00'
        ]);
    }
}
