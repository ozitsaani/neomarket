# NeoMarket - Sistem E-Commerce Sederhana API Driven

NeoMarket adalah sistem e-commerce sederhana berbasis Laravel yang menyediakan website customer, admin panel, dan RESTful API. Sistem ini memiliki fitur produk, kategori, cart, checkout, transaksi, payment dummy, authentication, authorization, API security, testing, serta dokumentasi.

## Tema UI

NeoMarket menggunakan tema **Clean Neobrutalism** dengan ciri:

- Warna pastel
- Border hitam
- Shadow tegas
- Card rounded
- Sidebar admin
- Topbar dashboard
- Tampilan modern dan clean

## Fitur Customer

- Register dan login
- Melihat katalog produk
- Filter produk berdasarkan kategori
- Search produk
- Melihat detail produk
- Menambahkan produk ke cart
- Mengubah quantity cart
- Checkout
- Melakukan payment dummy
- Melihat riwayat transaksi
- Melihat detail transaksi

## Fitur Admin

- Login admin
- Dashboard statistik
- Kelola produk
- Kelola kategori
- Melihat transaksi customer
- Melihat detail transaksi
- Mengubah status order
- Logout admin

## Fitur API

- RESTful API
- JSON response standar
- Validasi request
- Authentication menggunakan Laravel Sanctum
- Authorization menggunakan role admin dan customer
- Middleware proteksi endpoint
- CRUD kategori
- CRUD produk
- Cart API
- Checkout API
- Transaction API
- Payment dummy API

## Role User

### Admin

Admin dapat:

- Mengelola kategori
- Mengelola produk
- Melihat semua transaksi
- Mengubah status order

### Customer

Customer dapat:

- Register dan login
- Melihat produk
- Menambahkan produk ke cart
- Checkout
- Melakukan payment dummy
- Melihat riwayat transaksi sendiri

## Teknologi

- Laravel
- MySQL
- Laravel Sanctum
- Eloquent ORM
- Blade
- Vite
- Postman
- PHPUnit

## Struktur Database

Tabel utama:

- users
- categories
- products
- carts
- transactions
- transaction_items
- personal_access_tokens

## Instalasi

```bash
git clone https://github.com/username/neomarket.git
cd neomarket
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve