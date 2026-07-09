# CatetAja - Sistem Manajemen Inventaris

## 1. Tentang CatetAja
CatetAja adalah aplikasi manajemen inventaris berbasis web yang dirancang untuk mengotomatisasi pencatatan barang dan pelacakan transaksi peminjaman inventaris kantor oleh karyawan. Fokus utama dari aplikasi ini adalah untuk menciptakan alur kerja yang terstruktur, aman, dan mudah dipantau oleh berbagai pihak yang berkepentingan di dalam perusahaan.

## 2. Arsitektur dan Tech Stack
Aplikasi CatetAja dibangun menggunakan pola arsitektur **MVC (Model-View-Controller)** untuk memisahkan antara logika manipulasi data, antarmuka pengguna, dan alur kontrol aplikasi. 

Teknologi yang digunakan dalam pengembangan sistem ini adalah:
* **Backend:** Laravel 11 (PHP 8.2+)
* **Database:** MySQL 8.0
* **Frontend:**
  * Blade 
  * Tailwind CSS
  * JavaScript 
* **Authentification:** Laravel Breeze
* **Library Tambahan:**
  * **Chart.js:** Digunakan untuk merender grafik statistik peminjaman interaktif pada halaman Dasbor.
  * **html2pdf.js:** Digunakan untuk fitur ekspor laporan ke format PDF.

## 3. Hak Akses
* **Admin:** Memiliki kendali penuh atas sistem. Tugas utamanya adalah mengelola akun, yakni mengedit dan menghapus akun yang terdaftar.
* **Staff:** Bertindak sebagai operator utama di lapangan. Staff bertanggung jawab atas pengelolaan operasional data barang (CRUD) serta mencatat seluruh alur transaksi peminjaman dan pengembalian barang oleh karyawan.
* **Manager:** Memiliki akses pemantauan secara khusus (read-only). Manager menggunakan sistem ini untuk melihat laporan ketersediaan barang dan riwayat transaksi secara aktual guna keperluan evaluasi dan pengambilan keputusan.

## 4. Alur Sistem
**A. Manajemen Inventaris Barang**
* **Menambah Barang Baru (Admin dan Staff)**
  Login ke dalam sistem -> Masuk ke Halaman Inventaris Barang -> Klik tombol "Tambah Barang Baru" -> Isi formulir data barang -> Simpan data.
* **Mengedit Data Barang (Admin dan Staff)**
  Login ke dalam sistem -> Masuk ke Halaman Inventaris Barang -> Klik ikon Edit pada barang yang dituju -> Perbarui informasi barang -> Simpan perubahan.
* **Melihat Rincian Barang (Admin, Staff, dan Manager)**
  Login ke dalam sistem -> Masuk ke Halaman Inventaris Barang atau Halaman Laporan -> Klik ikon Detail (Mata) -> Informasi lengkap barang ditampilkan.
* **Menghapus Barang (Admin)**
  Login ke dalam sistem -> Masuk ke Halaman Inventaris Barang -> Klik ikon Hapus (Delete) pada barang yang dituju -> Sistem meminta konfirmasi -> Setujui penghapusan.

**B. Transaksi Peminjaman Barang**
* **Mencatat Peminjaman Baru (Admin dan Staff)**
  Login ke dalam sistem -> Masuk ke Halaman Data Peminjaman -> Klik tombol "Catat Peminjaman" -> Masukkan data peminjam dan barang yang dipinjam -> Simpan transaksi.
* **Memproses Pengembalian Barang (Admin dan Staff)**
  Login ke dalam sistem -> Masuk ke Halaman Data Peminjaman -> Cari riwayat transaksi yang sedang berjalan -> Klik tombol "Kembalikan" -> Konfirmasi penyelesaian pengembalian.
* **Menghapus Riwayat Peminjaman (Admin)**
  Login ke dalam sistem -> Masuk ke Halaman Data Peminjaman -> Klik ikon Hapus (Delete) pada riwayat yang dipilih -> Sistem meminta konfirmasi -> Setujui penghapusan.

**C. Manajemen Akun (Admin)**
* **Mengelola Akun**
  Login ke dalam sistem -> Masuk ke Halaman Kelola Akun -> Sistem menampilkan daftar seluruh pengguna yang terdaftar -> Admin dapat mengubah role atau menghapus akun pengguna dari sistem.

**D. Laporan dan Dasbor**
* **Melihat Laporan Tabel (Manager)**
  Login ke dalam sistem sebagai Manager -> Akses menu Laporan Barang atau Laporan Peminjaman -> Rekapitulasi data ditampilkan secara menyeluruh.
* **Mengunduh Laporan Excel/PDF (Admin, Staff, dan Manager)**
  Login ke dalam sistem -> Masuk ke Halaman Dasbor utama -> Klik tombol unduh "Excel" atau "PDF" -> Dokumen rekapitulasi diunduh ke perangkat pengguna.

## 5. Akun Login Testing
* **Admin:**
Email: admin123@gmail.com
Password : admin123
* **Staff:**
Email : staff123@gmail.com
Password : staff123
* **Manager:**
Email : manager123@gmail.com
Password : manager123

**JIKA REGISTER, OTOMATIS MASUK SEBAGAI STAFF**

## 6. Deployment
Sistem ini tidak hanya berjalan di lingkungan pengembangan lokal (localhost), tetapi juga telah berhasil di-*deploy* ke lingkungan *live server* melalui tautan berikut.

http://catetajainventory.web.id/

Berikut adalah spesifikasi infrastruktur server yang digunakan:
* **Server Hosting:** Virtual Private Server (VPS) dengan sistem operasi **Ubuntu**.
* **Web Server:** **Nginx**.
* **Version Control System (VCS):** Menggunakan **Git** dan **GitHub** untuk manajemen repositori. Proses pembaruan kode di VPS dilakukan menggunakan metode penarikan langsung (*Git Pull*).
* **Keamanan (SSL/TLS):** Lalu lintas data diamankan menggunakan protokol `HTTPS` dengan sertifikat SSL gratis dari Let's Encrypt yang dikonfigurasi secara otomatis menggunakan **Certbot**.

