<p align="left"> <a href="https://codeigniter.com" target="_blank"> <img src="https://img.shields.io/badge/CodeIgniter-EE4622?style=for-the-badge&logo=codeigniter&logoColor=white" alt="CodeIgniter" /> </a> <a href="https://www.php.net" target="_blank"> <img src="https://img.shields.io/badge/PHP-777BB3?style=for-the-badge&logo=php&logoColor=white" alt="PHP" /> </a> <a href="https://developer.mozilla.org/en-US/docs/Web/HTML" target="_blank"> <img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white" alt="HTML5" /> </a> <a href="https://developer.mozilla.org/en-US/docs/Web/CSS" target="_blank"> <img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white" alt="CSS3" /> </a> </p>

| No | Nama         | NIM        |
| -- | ------------ | ---------- |
| 1  | BAYU AJI YUWONO | 312310492  |
| 2  | MUHAMMAD ARIF MULYANTO | 312310359  |
| 3  | LUTPIAH AINUS SHIDDIK | 312310474 |
| 4  | ANANDA RAHMADANI  | 312310461 |

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

![WhatsApp Image 2025-07-03 at 21 33 09](https://github.com/user-attachments/assets/82bbf40b-0dd8-47d4-a532-b70f0a050269)

## USE CASE 
![WhatsApp Image 2025-07-04 at 18 10 19 (1)](https://github.com/user-attachments/assets/4fc10529-0a5d-405c-b19d-cc1a3801d9de)


📌 Penjelasan:

* Tabel warga: menyimpan data penduduk RT
* Tabel transaksi: menyimpan catatan pemasukan/pengeluaran
* Tabel kategori: untuk mengelompokkan jenis transaksi
* Tabel users: akun login admin/pengurus

---

## 📱 UI/UX Mockup

Mockup antarmuka aplikasi yang dirancang menggunakan layout responsif dan sederhana:

![WhatsApp Image 2025-07-03 at 22 27 55](https://github.com/user-attachments/assets/8551d2d4-854b-4cb1-8af6-2bea640679a5)


📌 Penjelasan:

* Tampilan clean dan mudah digunakan oleh pengurus RT
* Warna netral dan tipografi jelas
* Navigasi utama di bagian atas atau sidebar

---

## 🦾 Storyboard Alur Sistem

Storyboard menggambarkan alur proses penggunaan aplikasi oleh pengurus RT:

![WhatsApp Image 2025-07-03 at 22 27 55 (2)](https://github.com/user-attachments/assets/c1c82ce7-cdc3-4a29-9fb7-102a8d991560)


📌 Penjelasan:

1. Pengurus login ke sistem
2. Melihat dashboard ringkasan
3. Menambah data warga baru
4. Mencatat pembayaran atau pengeluaran
5. Melihat dan mencetak laporan

---

## 🖼️ Screenshot Aplikasi

Berikut adalah beberapa tampilan antarmuka website beserta penjelasannya:

1. Halaman Login

- Halaman login untuk masuk ke sistem. Pengguna memasukkan email dan password untuk mengakses sistem.
  
![{0BEB343E-7E28-43C8-86F8-DFFE7E9A011E}](https://github.com/user-attachments/assets/0958ffe5-d4ac-4309-a150-97124484b2df)

2. Halaman Register

- Halaman pendaftaran akun untuk pengurus RT baru. Form terdiri dari nama, email, dan password.
  
![{52D9698D-1873-4C86-AD63-C2929C04F82E}](https://github.com/user-attachments/assets/615581ec-9ef7-412f-b889-1825ace74a40)

3. Home / Dashboard

- Menampilkan ringkasan saldo kas, total warga, dan total iuran bulan ini. Navigasi ke fitur utama tersedia di sini.
  
![{AE4EB5C0-1802-4694-9523-401834C6AF5D}](https://github.com/user-attachments/assets/f80784f4-474c-421f-8962-fdaddf54f338)

4. Halaman Data Warga

- Halaman untuk melihat dan mengelola daftar warga. Dilengkapi tombol edit dan hapus untuk setiap warga.
  
![{F810E92A-A268-469C-BFAB-2EAA82BC1DF1}](https://github.com/user-attachments/assets/953648de-853b-402a-b233-8279189bf0ec)

5. Form Pembayaran

- Form pencatatan pembayaran iuran kas oleh warga berdasarkan nama dan bulan.
  
![{BBE026E1-A7E1-4378-B2EE-6565780A0D66}](https://github.com/user-attachments/assets/8e575833-4cf0-47de-a415-feaa9d15cc7c)

6. Buat Laporan Keuangan

- Form untuk memilih tanggal dan jenis transaksi dalam menyusun laporan keuangan RT.
  
![{544FD4EE-BDD3-48F5-BA65-E2F84F4A65E3}](https://github.com/user-attachments/assets/826a0a1a-6177-48aa-bcb2-6908077c27e3)

7. Halaman Hasil Laporan Keuangan

- Halaman yang menampilkan rekap hasil laporan keuangan setelah semua data transaksi dikompilasi. Memudahkan pengguna melihat status keuangan akhir bulan dengan jelas dan terperinci.
  
![{54921748-11A1-4A3B-BA06-1BF8EBAE9B80}](https://github.com/user-attachments/assets/5285ac4f-db52-4193-9a08-769608fb83a8)

8. Halaman Cetak Laporan
   
- Tampilan laporan yang bisa dicetak ke PDF, mencakup total pemasukan dan pengeluaran.
  
![{58BB5357-3A4D-42B2-8B88-BDF205E9F611}](https://github.com/user-attachments/assets/49f497cd-a112-437b-ad23-e00a35d99877)

9. Halaman Profil

- Menampilkan informasi akun pengguna serta opsi untuk memperbarui data profil dan logout.
  
![{04B55762-A714-4135-B7F5-CB95351F520E}](https://github.com/user-attachments/assets/bc91b356-5710-4ac9-9509-4a7d86aba50c)

---


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
