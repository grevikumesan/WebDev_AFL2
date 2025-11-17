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
        User::truncate();

        $usersData = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => '12345678',
                'image' => null,
                'role' => 'admin'
            ],
            [
                'name' => 'Customer',
                'email' => 'customer@gmail.com',
                'password' => '12345678',
                'image' => null,
                'role' => 'customer'
            ],
        ];

        foreach ($usersData as $user) {
            User::create($user);
        }
    }
}
