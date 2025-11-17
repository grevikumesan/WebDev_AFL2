<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate(); //hapus data lama agar tidak duplikat jika di seed lagi

        $usersData = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => 'password',
                'image' => null,
                'role' => 'admin'
            ],
            [
                'name' => 'Customer',
                'email' => 'customer@gmail.com',
                'password' => 'password',
                'image' => null,
                'role' => 'customer'
            ],
        ];

        foreach ($usersData as $user) {
            User::create($user);
        }
    }
}
