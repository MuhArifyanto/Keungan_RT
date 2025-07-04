# 💼 KASRT — Aplikasi Manajemen Keuangan RT

KASRT adalah aplikasi berbasis web menggunakan CodeIgniter 4 yang dirancang untuk membantu pengurus RT dalam mencatat keuangan secara digital. Aplikasi ini mempermudah proses pencatatan iuran, pengeluaran, pembuatan laporan, dan pengelolaan data warga secara efisien dan transparan.

---

## 📌 Fitur Utama

✅ Autentikasi Pengguna (Login & Register)
Digunakan untuk mengamankan akses ke sistem. Pengurus RT harus login menggunakan akun terdaftar untuk mengakses seluruh fitur aplikasi.

✅ Manajemen Data Warga (Tambah, Edit, Hapus)
Fitur ini memungkinkan admin untuk mengelola seluruh data warga RT, termasuk nama, alamat, nomor telepon, dan status kepemilikan rumah.

✅ Pencatatan Pembayaran Iuran
Setiap pembayaran iuran kas warga dapat dicatat berdasarkan nama warga, bulan pembayaran, dan nominal. Sistem juga dapat mencatat status pembayaran apakah sudah atau belum.

✅ Input Pengeluaran Kas
Fitur ini digunakan untuk mencatat pengeluaran yang dilakukan oleh RT seperti pembelian barang, pembayaran listrik, atau kegiatan sosial. Setiap pengeluaran dicatat dengan keterangan dan nominal.

✅ Dashboard Ringkasan Keuangan
Menampilkan informasi ringkas seperti total saldo kas, jumlah warga, total iuran bulan ini, serta shortcut ke fitur penting lainnya. Ditampilkan secara visual agar mudah dipahami.

✅ Laporan Bulanan (Filter Periode)
Laporan keuangan dapat difilter berdasarkan bulan atau tahun. Laporan ini menampilkan semua transaksi pemasukan dan pengeluaran serta total saldo akhir.

✅ Cetak Laporan ke PDF
Laporan keuangan yang ditampilkan bisa langsung dicetak atau diekspor dalam format PDF. Cocok digunakan saat rapat warga atau pelaporan ke pihak lain.

✅ Halaman Profil dan Logout
Setiap pengguna dapat melihat dan memperbarui profil mereka. Fitur logout memastikan keamanan akun pengguna setelah selesai digunakan.

---

## 📂 Struktur Direktori Penting

| Folder/Path      | Fungsi                                |
| ---------------- | ------------------------------------- |
| /app/Controllers | Mengatur alur halaman & aksi pengguna |
| /app/Models      | Akses database (CRUD, filter, dsb)    |
| /app/Views       | Tampilan web menggunakan Bootstrap    |
| /public/         | File statis: CSS, gambar, JS          |
| /app/Config      | Pengaturan sistem & database          |

---

## 🧐 Entity Relationship Diagram (ERD)

ERD berikut menggambarkan relasi antar tabel di database KASRT:

![ERD](docs/erd.png)

📌 Penjelasan:

* Tabel warga: menyimpan data penduduk RT
* Tabel transaksi: menyimpan catatan pemasukan/pengeluaran
* Tabel kategori: untuk mengelompokkan jenis transaksi
* Tabel users: akun login admin/pengurus

---

## 📱 UI/UX Mockup

Mockup antarmuka aplikasi yang dirancang menggunakan layout responsif dan sederhana:

![Mockup](docs/mockup.png)

📌 Penjelasan:

* Tampilan clean dan mudah digunakan oleh pengurus RT
* Warna netral dan tipografi jelas
* Navigasi utama di bagian atas atau sidebar

---

## 🦾 Storyboard Alur Sistem

Storyboard menggambarkan alur proses penggunaan aplikasi oleh pengurus RT:

![Storyboard](docs/storyboard.png)

📌 Penjelasan:

1. Pengurus login ke sistem
2. Melihat dashboard ringkasan
3. Menambah data warga baru
4. Mencatat pembayaran atau pengeluaran
5. Melihat dan mencetak laporan

---

## 🖼️ Screenshot Aplikasi

Berikut adalah beberapa tampilan antarmuka website beserta penjelasannya:

Berikut adalah beberapa tampilan antarmuka website beserta penjelasannya:

| Halaman        | Gambar                                     | Penjelasan                                                                                                         |
| -------------- | ------------------------------------------ | ------------------------------------------------------------------------------------------------------------------ |
| Login          | ![](screenshots/login.png)                 | Halaman login untuk masuk ke sistem. Pengguna memasukkan email dan password untuk mengakses sistem.                |
| Register       | ![](screenshots/register.png)              | Halaman pendaftaran akun untuk pengurus RT baru. Form terdiri dari nama, email, dan password.                      |
| Home/Dashboard | ![](screenshots/home.png)                  | Menampilkan ringkasan saldo kas, total warga, dan total iuran bulan ini. Navigasi ke fitur utama tersedia di sini. |
| Data Warga     | ![](screenshots/daftar_warga.png)          | Halaman untuk melihat dan mengelola daftar warga. Dilengkapi tombol edit dan hapus untuk setiap warga.             |
| Pembayaran     | ![](screenshots/pembayaran.png)            | Form pencatatan pembayaran iuran kas oleh warga berdasarkan nama dan bulan.                                        |
| Buat Laporan   | ![](screenshots/buat_laporan_keuangan.png) | Form untuk memilih tanggal dan jenis transaksi dalam menyusun laporan keuangan RT.                                 |
| Cetak Laporan  | ![](screenshots/cetak_laporan.png)         | Tampilan laporan yang bisa dicetak ke PDF, mencakup total pemasukan dan pengeluaran.                               |
| Halaman Profil | ![](screenshots/profile.png)               | Menampilkan informasi akun pengguna serta opsi untuk memperbarui data profil dan logout.                           |

---

## 📦 Instalasi Lokal (Development)

1. Clone repositori:

   ```bash
   git clone https://github.com/username/kasrt.git
   cd kasrt
   ```

2. Import database MySQL (file .sql tersedia di /database)

3. Konfigurasi koneksi database:
   Buka /app/Config/Database.php dan sesuaikan:

   ```php
   public $default = [
     'hostname' => 'localhost',
     'username' => 'root',
     'password' => '',
     'database' => 'kasrt',
     ...
   ];
   ```

4. Jalankan dengan:

   ```bash
   php spark serve
   ```

5. Akses melalui:
   [http://localhost:8080](http://localhost:8080)

---

## 🤝 Kontribusi

Pull request sangat diterima! Silakan fork repository ini dan kirimkan saran atau fitur baru untuk pengembangan bersama.


## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
