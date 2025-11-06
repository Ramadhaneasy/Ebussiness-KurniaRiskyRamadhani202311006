💼 EBUSINESS POS - APLIKASI LARAVEL BERBASIS ROLE

📝 Deskripsi Proyek

Proyek ini adalah implementasi awal dari sistem Point of Sale (POS) atau aplikasi eBusiness menggunakan framework Laravel, yang berfokus pada manajemen otentikasi (login) dan otorisasi (hak akses) berbasis peran (Role-Based Access Control / RBAC).

Aplikasi ini membedakan akses antara Administrator (Admin), yang memiliki hak penuh ke dashboard manajemen, dan User Biasa (Kasir), yang memiliki akses terbatas ke dashboard operasional.

✨ Fitur Utama (Implementasi Tugas)

Berdasarkan instruksi yang diberikan, fitur-fitur yang telah berhasil diimplementasikan adalah:

Instalasi Laravel Breeze: Implementasi penuh sistem Login dan Register (Authentication Scaffolding).

Role Management: Penambahan kolom role pada tabel users untuk membedakan peran (admin dan user).

Dashboard Berbasis Peran:

Dashboard User: Dapat diakses oleh semua pengguna yang terotentikasi dan terverifikasi di route /dashboard.

Dashboard Admin: Dashboard manajemen eksklusif yang hanya dapat diakses oleh pengguna dengan role='admin' di route /admin.

Admin Middleware: Implementasi custom middleware bernama admin untuk memproteksi route /admin dari akses pengguna biasa.

🛠️ Panduan Instalasi (Development)

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek secara lokal:

1. Kloning Repositori & Instal Dependensi

# Kloning dari GitHub
git clone [https://github.com/nama_kalian/ebusiness2-nama_kalian.git](https://github.com/nama_kalian/ebusiness2-nama_kalian.git)
cd ebusiness2-nama_kalian

# Instal dependensi PHP (Composer)
composer install

# Instal dependensi Node.js (NPM)
npm install


2. Konfigurasi Database

Salin file .env.example menjadi .env.

cp .env.example .env


Atur kredensial database Anda (DB_DATABASE, DB_USERNAME, dll.) di file .env.

Buat App Key.

php artisan key:generate


3. Migrasi dan Seeder (Membuat Tabel & Akun Uji)

Jalankan migrasi untuk membuat semua tabel (termasuk users, orders, dan activities) dan mengisi data akun uji coba.

# Menjalankan migrasi dan seeder secara bersamaan
php artisan migrate:fresh --seed


4. Kompilasi Aset dan Jalankan Server

# Kompilasi aset CSS/JS (Tailwind)
npm run dev

# Jalankan server lokal Laravel
php artisan serve


🔑 Akun Uji Coba

Setelah menjalankan php artisan migrate:fresh --seed, Anda dapat menguji hak akses menggunakan akun berikut (berdasarkan DatabaseSeeder.php terakhir):

Peran (Role)

Email

Password

Status Akses ke /admin

Admin

susisusi@admin.com

susi123

✅ Diizinkan

User Biasa

yonoyono@user.com

yono123

❌ Ditolak (Redirect ke /dashboard)

🖼️ Dokumentasi Implementasi

Berikut adalah bukti implementasi dari fitur-fitur yang diminta. (Ganti teks di bawah ini dengan link gambar screenshot Anda)

1. Hasil php artisan route:list

Tunjukkan bahwa middleware admin telah diterapkan dengan benar pada route /admin.

2. Halaman Login

Bukti bahwa sistem otentikasi (Breeze) berfungsi.

3. Dashboard User

Bukti bahwa user biasa (yonoyono@user.com) dapat mengakses /dashboard dan hanya melihat data pribadinya (jika ada).

4. Dashboard Admin

Bukti bahwa admin (susisusi@admin.com) dapat mengakses /admin dan melihat dashboard manajemen.

🤝 Kontributor

[Nama Anda] - [NIM/Role Anda]