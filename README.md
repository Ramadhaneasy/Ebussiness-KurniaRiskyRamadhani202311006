# 📝 Dokumentasi Tugas Laravel Ebusiness (RBAC)

Proyek ini mendokumentasikan implementasi sistem otorisasi berbasis peran (**Role-Based Access Control / RBAC**) pada aplikasi Laravel, sesuai dengan langkah-langkah tugas.

## ✅ Implementasi Role-Based Access Control (RBAC)

Berikut adalah ringkasan fitur utama yang telah diimplementasikan:

1.  **Instalasi Laravel Breeze:** Sistem login dan register dasar.
2.  **Kolom `role`:** Ditambahkan pada tabel `users` untuk membedakan `admin` dan `user`.
3.  **Middleware Admin:** Dibuat untuk memproteksi *route* `/admin`.
4.  **Route:**
    * `/dashboard` diakses oleh `user` biasa.
    * `/admin` hanya diakses oleh `admin`.

---

## 🔑 Akun Uji Coba

Akun yang digunakan untuk menguji hak akses (dibuat melalui Seeder):

| Peran | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `susisusi@admin.com` | `susi123` |
| **User Biasa** | `yonoyono@user.com` | `yono123` |

---

## 🖼️ Bukti Visual (Screenshots)

### 1. Halaman Login

Halaman *Login* standar yang disediakan oleh Laravel Breeze.

![Screenshot Halaman Login](screenshoot/halaman_login.png)

### 2. Dashboard User (/dashboard)

Tampilan dashboard yang dapat diakses oleh **User Biasa** (`yonoyono@user.com`).

![Screenshot Dashboard User](screenshoot/sebagai_user.png)

### 3. Dashboard Admin (/admin)

Tampilan dashboard khusus yang hanya dapat diakses oleh **Admin** (`susisusi@admin.com`).

![Screenshot Dashboard Admin](screenshoot/sebagai_admin.png)

### 4. Hasil `php artisan route:list`

Output yang menunjukkan *middleware* `admin` telah berhasil diterapkan pada *route* `/admin`.

![Screenshot php artisan route:list](screenshoot/route_list.png)

---

**Dibuat oleh: [Kurnia Risky Ramadhani]**
