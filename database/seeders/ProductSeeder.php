<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder {    //berisi data dari produk

    public function run(): void {

    Product::truncate();    //hapus data lama agar tidak duplikat jika di seed lagi

        // ubah jadi array
        $categories = Category::all()->pluck('id', 'name')->toArray();
        $productsData = [
            [
                'name' => 'Diplomat Mild Berry 12',
                'category_name' => 'Rokok',
                'price' => 18000,
                'unit' => '',
                'image' => 'diplomat-mb-12.jpg'
            ],
            [
                'name' => 'Diplomat Mild Berry 16',
                'category_name' => 'Rokok',
                'price' => 24700,
                'unit' => '',
                'image' => 'diplomat-mb-16.jpg'
            ],
            [
                'name' => 'Wismilak Arja 12',
                'category_name' => 'Rokok',
                'price' => 9750,
                'unit' => '',
                'image' => 'WismilakArja12.jpg'
            ],
            [
                'name' => 'Marlboro Merah',
                'category_name' => 'Rokok',
                'price' => 49500,
                'unit' => '',
                'image' => 'MarlboroMerah.jpg'
            ],
            [
                'name' => 'LA Merah16',
                'category_name' => 'Rokok',
                'price' => 32900,
                'unit' => '',
                'image' => 'lamerah-16.jpeg'
            ],
            [
                'name' => 'Promild Putih',
                'category_name' => 'Rokok',
                'price' => 31000,
                'unit' => '',
                'image' => 'PromildPutih.jpg'
            ],
            [
                'name' => 'Surya 12',
                'category_name' => 'Rokok',
                'price' => 25000,
                'unit' => '',
                'image' => 'Surya12.jpg'
            ],
            [
                'name' => 'Gula',
                'category_name' => 'Sembako',
                'price' => 15000,
                'unit' => 'kg',
                'image' => 'Gula.jpg'
            ],
            [
                'name' => 'Indomie Goreng',
                'category_name' => 'Sembako',
                'price' => 112000,
                'unit' => '40pcs',
                'image' => 'Indomie.jpg'
            ],
            [
                'name' => 'Lencana Merah (Terigu)',
                'category_name' => 'Sembako',
                'price' => 175000,
                'unit' => 'karung',
                'image' => 'LencanaMerah.jpg'
            ],
            [
                'name' => 'Payung Biru (Terigu)',
                'category_name' => 'Sembako',
                'price' => 172500,
                'unit' => 'karung',
                'image' => 'PayungBIRU.jpg'
            ],
            [
                'name' => 'Cleo Galon',
                'category_name' => 'Sembako',
                'price' => 17500,
                'unit' => '',
                'image' => 'cleo-galon.jpg'
            ],
            [
                'name' => 'Sampo Dove',
                'category_name' => 'Sampo & Sabun',
                'price' => 9500,
                'unit' => 'renteng',
                'image' => 'dove.jpeg'
            ],
            [
                'name' => 'Sampo Emeron',
                'category_name' => 'Sampo & Sabun',
                'price' => 5000,
                'unit' => 'renteng',
                'image' => 'SampoEmeron.jpg'
            ],
            [
                'name' => 'Sampo Lifebuoy',
                'category_name' => 'Sampo & Sabun',
                'price' => 5000,
                'unit' => 'renteng',
                'image' => 'SampoLifebuoy.jpg'
            ],
            [
                'name' => 'Sabun Lifebuoy (batang)',
                'category_name' => 'Sampo & Sabun',
                'price' => 3500,
                'unit' => 'biji',
                'image' => 'sabunlifebuoy.jpg'
            ],
            [
                'name' => 'Sabun Giv (batang)',
                'category_name' => 'Sampo & Sabun',
                'price' => 3000,
                'unit' => 'biji',
                'image' => 'SabunGiv.jpg'
            ],
            [
                'name' => 'Sabun Shinzui (batang)',
                'category_name' => 'Sampo & Sabun',
                'price' => 4000,
                'unit' => 'biji',
                'image' => 'SabunShinzui.jpg'
            ]
        ];

        foreach ($productsData as $product) {
            Product::create([
                'name' => $product['name'],
                'price' => $product['price'],
                'unit' => $product['unit'],
                'image' => $product['image'],
                'category_id' => $categories[ $product['category_name'] ]
            ]);
        }
    }
}
