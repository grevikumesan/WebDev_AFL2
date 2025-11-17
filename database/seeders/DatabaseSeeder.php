<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder {
    public function run(): void {

        Schema::disableForeignKeyConstraints();

        $this->call([
            CategorySeeder::class, // jalan pertama
            ProductSeeder::class,  //kedua
            UserSeeder::class,  //kalo nanti mau bikin seeder user
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
