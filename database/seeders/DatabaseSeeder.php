<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. AKUN ADMIN BARU
        // Nama: Susi Susi
        // Email: susisusi@admin.com
        // Password: susi123
        User::updateOrCreate(
            ['email' => 'susisusi@admin.com'], // Kondisi pencarian
            [
                'name' => 'Susi Susi (Admin)',
                'password' => Hash::make('susi123'), // Password yang di-hash
                'role' => 'admin', // PERAN ADMIN
                'email_verified_at' => now(), 
            ]
        );

        // 2. AKUN USER BIASA BARU
        // Nama: Yono Yono
        // Email: yonoyono@user.com
        // Password: yono123
        User::updateOrCreate(
            ['email' => 'yonoyono@user.com'], // Kondisi pencarian
            [
                'name' => 'Yono Yono (Kasir)',
                'password' => Hash::make('yono123'),
                'role' => 'user', // PERAN USER BIASA
                'email_verified_at' => now(), 
            ]
        );
        
        // Catatan: Jika Anda memiliki DummyDataSeeder, panggil di sini:
        // $this->call(DummyDataSeeder::class); 
    }
}