<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat atau memperbarui (updateOrCreate) akun Admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // Kondisi untuk mencari
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'), // **Ganti 'password' dengan password yang lebih aman!**
                'role' => 'admin', // Kunci utama untuk middleware
                'email_verified_at' => now(), // Anggap sudah terverifikasi
            ]
        );

        // Opsional: Membuat akun User biasa untuk perbandingan
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Standard User',
                'password' => Hash::make('password'),
                'role' => 'user', // Peran 'user'
                'email_verified_at' => now(),
            ]
        );
    }
}