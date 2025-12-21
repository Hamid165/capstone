<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Akun Admin
        User::create([
            'name' => 'Admin Dhawuh',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admindhawuh'), // Passwordnya: admindhawuh
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Kantor Pusat Purwokerto',
        ]);

        // Buat Akun Customer Contoh
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
    }
}
