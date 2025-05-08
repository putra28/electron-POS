

## Tentang Aplikasi

Sistem Point of Sale (POS) ini dibangun menggunakan framework Laravel untuk mengelola transaksi penjualan dan inventaris. Sistem ini mendukung dua peran pengguna: admin dan kasir.

### Beberapa Fitur yang tersedia:
- Panel Admin :
  - Dashboard
    - Menampilkan Data penjualan dan informasi akun
  - Data Kategori
    - Operasi CRUD untuk Kategori Produk
  - Data Produk
    - Operasi CRUD untuk data produk
    - Kemampuan untuk mencetak laporan produk
  - Data Petugas
    - Operasi CRUD untuk akun admin dan kasir
  - Data Penjualan
    - Mengelola transaksi penjualan
    - Mencetak struk penjualan
    - Menghapus transaksi
    - Mencetak laporan penjualan
  - Data Member
    - Operasi CRUD untuk data member

- Panel Kasir :
  - Dashboard
    - Menampilkan Data penjualan dan informasi akun
  - Transaksi
    - Memungkinkan kasir melakukan transaksi penjualan dengan menambahkan produk ke keranjang
    - Menyesuaikan jumlah data keranjang
    - Memilih member yang membeli
    - Memasukkan total pembayaran
    - Mengirimkan transaksi
  - Tambah Member
    - Memungkinkan kasir menambahkan data member baru
  - Data Produk
    - Memungkinkan kasir untuk mengelola stok produk
  - Data Penjualan
    - Mengelola transaksi penjualan
    - Mencetak struk penjualan
    - Mencetak laporan penjualan

## Instalasi
#### Via Git
```bash
git clone https://github.com/putra28/ProjekKasir.git
```

### Download ZIP
[Link](https://github.com/putra28/ProjekKasir/archive/refs/heads/main.zip)

### Setup Aplikasi
Jalankan perintah 
```bash
composer update
```
atau:
```bash
composer install
```
Copy file .env dari .env.example
```bash
cp .env.example .env
```
Konfigurasi file .env
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ujikompos
DB_USERNAME=root
DB_PASSWORD=
```
Menjalankan aplikasi
```bash
php artisan serve
```
```bash
USERNAME ADMIN : admin
PASSWORD ADMIN : admin123

USERNAME KASIR : kasir
PASSWORD KASIR : kasir123
```
## License

[MIT license](https://opensource.org/licenses/MIT)
