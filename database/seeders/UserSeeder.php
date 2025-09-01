<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat user Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@simandi.com',
            'password' => Hash::make('password'), // Ganti 'password' dengan password yang aman
            'role' => 'admin',
        ]);

        // Membuat user Pelanggan
        User::create([
            'name' => 'Pelanggan User',
            'email' => 'pelanggan@simandi.com',
            'password' => Hash::make('password123'), // Ganti 'password123' dengan password yang aman
            'role' => 'pelanggan',
        ]);
    }
}
