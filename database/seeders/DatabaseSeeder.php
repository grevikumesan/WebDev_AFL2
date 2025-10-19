<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        $this->call([
            CategorySeeder::class, // jalan pertama
            ProductSeeder::class,  //kedua
            // UserSeeder::class,  //kalo nanti mau bikin seeder user
        ]);
    }
}
