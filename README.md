📝 Dokumentasi Tugas Laravel Ebusiness

Proyek ini mendokumentasikan implementasi sistem otorisasi berbasis peran (Role-Based Access Control / RBAC) pada aplikasi Laravel, sesuai dengan langkah-langkah yang ditentukan.

✅ Implementasi Role-Based Access Control (RBAC)

Berikut adalah ringkasan fitur utama yang telah diimplementasikan:

Instalasi Laravel Breeze: Sistem login dan register dasar.

Kolom role: Ditambahkan pada tabel users untuk membedakan admin dan user.

Middleware Admin: Dibuat untuk memproteksi route /admin.

Route:

/dashboard diakses oleh user biasa.

/admin hanya diakses oleh admin.

🔑 Akun Uji Coba

Akun yang digunakan untuk menguji hak akses:

Peran

Email

Password

Admin

susisusi@admin.com

susi123

User Biasa

yonoyono@user.com

yono123

🖼️ Bukti Visual (Screenshots)

1. Halaman Login

Halaman Login standar yang disediakan oleh Laravel Breeze.

!(https://www.google.com/search?q=https://placehold.co/800x400/06b6d4/ffffff%3Ftext%3DScreenshot%2BHalaman%2BLogin)

2. Dashboard User (/dashboard)

Tampilan dashboard yang dapat diakses oleh User Biasa (yonoyono@user.com).

!(https://www.google.com/search?q=https://placehold.co/800x400/34d399/000000%3Ftext%3DScreenshot%2BDashboard%2BUser)

3. Dashboard Admin (/admin)

Tampilan dashboard khusus yang hanya dapat diakses oleh Admin (susisusi@admin.com).

4. Hasil php artisan route:list

Output yang menunjukkan middleware admin telah berhasil diterapkan pada route /admin.

!(https://www.google.com/search?q=https://placehold.co/800x400/9333ea/ffffff%3Ftext%3DScreenshot%2Bphp%2Bartisan%2Broute:list)

Dibuat oleh: [Nama Anda]