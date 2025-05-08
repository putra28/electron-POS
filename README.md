# Point of Sale (POS) Frontend — Laravel (Web) & Electron (Desktop)

Ini adalah versi desktop dari proyek frontend Point of Sale (POS) berbasis Laravel, dikemas menggunakan Electron JS agar dapat dijalankan sebagai aplikasi desktop (Windows, Linux, dll).
Proyek ini berasal dari proyek utama Laravel frontend:
👉 https://github.com/putra28/ujikom-pos

Proyek ini tetap mengonsumsi REST API dari backend di:
👉 https://github.com/putra28/Ujikom-API

Frontend dan backend harus dikonfigurasi untuk saling terhubung sesuai pengaturan di .env.

---

## 🚀 Fitur Aplikasi

### 👨‍💼 Admin

#### Dashboard
- Menampilkan tanggal realtime, ringkasan penjualan dan pendapatan bulanan, serta total produk
- Menampilkan informasi pengguna
- Menampilkan riwayat transaksi terakhir (semua pengguna)

#### Master Data
- Produk: CRUD produk dan detail
- Kategori: CRUD kategori
- Petugas/Karyawan: CRUD data petugas
- Supplier: CRUD supplier
- Member: CRUD member

#### Manajemen Toko
- Data Pembelian:
  - Melihat data dan detail pembelian
  - Filter berdasarkan periode
  - Tambah pembelian produk dari supplier
  - Ubah status pembelian
  - Hapus data pembelian
- Data Pengeluaran:
  - Melihat dan filter data pengeluaran
  - Tambah dan ubah data pengeluaran
  - Hapus data pengeluaran tidak valid

#### Karyawan
- Shift: CRUD jadwal shift karyawan
- Kehadiran: Lihat dan hapus data absensi
- Izin: CRUD pengajuan izin dan ubah statusnya

#### Data Transaksi
- Riwayat transaksi per bulan dan detail transaksi

#### Laporan
- Stok: Riwayat perubahan stok produk
- Penjualan:
  - Ringkasan penjualan tahunan
  - Produk terlaris
  - Grafik penjualan bulanan
  - Karyawan dengan penjualan terbanyak
- Pembelian:
  - Ringkasan pembelian tahunan
  - Supplier aktif
  - Produk paling sering dibeli
  - Grafik pembelian bulanan
- Pengeluaran:
  - Ringkasan keuangan tahunan (pendapatan, HPP, laba bersih)
  - Perbandingan grafik pendapatan vs pengeluaran

---

### 🧾 Kasir

#### Dashboard
- Ringkasan penjualan dan pendapatan bulanan
- Transaksi terakhir (khusus kasir login)

#### Transaksi
- Penjualan produk

#### Member
- Tambah dan lihat data member beserta detail

#### Produk
- Lihat semua produk dan detailnya

#### Riwayat Transaksi
- Riwayat transaksi per kasir dan berdasarkan periode

#### Pengajuan Izin
- Ajukan, lihat, dan batalkan pengajuan izin absensi

---

## 📦 Cara Install

### 1. Clone Repositori Ini

```bash
git clone https://github.com/username/pos-frontend.git
cd electron-POS
```

### 2. Install & Jalankan API Backend
Proyek ini membutuhkan backend API yang tersedia di:
👉 https://github.com/putra28/Ujikom-API

Silakan ikuti petunjuk instalasi di sana terlebih dahulu.

Pastikan backend ini berjalan di http://localhost:1111 (atau sesuaikan dengan .env frontend).

### 3. Install Laravel Frontend (Versi Web)
```bash
cd Ujikom-POS
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

### 4. Install Electron App (Versi Desktop)
```bash
cd ../electron-POS
npm install
npm run start
```
Electron akan secara otomatis menjalankan Laravel menggunakan perintah php artisan serve dan membuka aplikasi pada jendela desktop.

## 📁 Struktur Folder
```bash
/electron-app
├── /Ujikom-POS       # Laravel frontend versi web
├── /electron-POS           # Electron desktop app
├── .gitignore
└── README.md
```

## 📄 Catatan
- node_modules diabaikan melalui .gitignore, jadi pastikan jalankan npm install di electron-app.
- Proyek ini dikembangkan untuk keperluan internal/UKK dan tidak untuk produksi langsung.
- Silakan modifikasi Ujikom-POS/config.api.php agar sesuai dengan URL API yang kamu jalankan secara lokal.
