# Rice Berapi

Aplikasi web e-commerce untuk UMKM Nasi Bakar yang dibangun dengan Laravel 12. Sistem lengkap untuk penjualan online dengan fitur manajemen produk, keranjang belanja, checkout, sistem pembayaran dengan verifikasi, dan admin panel.

## Fitur Utama

### Untuk Customer

- Landing Page dengan carousel hero section
- Katalog Produk dengan filter kategori (Ayam, Seafood, Original)
- Detail Produk dengan informasi lengkap dan review
- Keranjang Belanja dengan konfirmasi update quantity
- Checkout dengan form pengiriman dan metode pembayaran (COD/Transfer Bank)
- Upload Bukti Transfer untuk verifikasi pembayaran (max 2MB, JPG/PNG)
- Invoice PDF - Preview dan download invoice pesanan
- Tracking Status Pesanan (Pending, Processing, Ready, Completed, Cancelled)
- Review & Rating produk dengan bintang 1-5
- Notifikasi real-time untuk update status pesanan

### Untuk Admin

- Dashboard dengan statistik lengkap dan chart monitoring
- Kelola Produk - CRUD dengan upload gambar
- Kelola Pesanan - Update status dan konfirmasi pembayaran
- Verifikasi Pembayaran - Review bukti transfer sebelum konfirmasi
- Smart Payment Button - Auto-disable jika bukti transfer belum diupload
- Invoice Management - Preview dan download untuk setiap pesanan
- Kelola Review - Monitor dan moderasi review customer

### Sistem Pembayaran

**Metode Pembayaran:**

- Cash on Delivery (COD) - Pembayaran saat pengiriman
- Transfer Bank - Transfer dengan upload bukti

**Payment Verification Flow:**

1. Customer pilih metode Transfer Bank saat checkout
2. Customer upload bukti transfer (JPG/PNG, max 2MB)
3. Admin review bukti transfer di panel admin
4. Admin konfirmasi pembayaran setelah verifikasi
5. Customer dapat notifikasi konfirmasi

## Teknologi

- Backend: Laravel 12 (PHP 8.2+)
- Frontend: Blade Templates + Tailwind CSS
- Database: MySQL
- PDF Generation: barryvdh/laravel-dompdf v3.1.1
- Charts: Chart.js
- Storage: Laravel Storage
- Authentication: Session-based Auth

## Instalasi

### Prerequisites

- PHP >= 8.2
- Composer
- MySQL/MariaDB

### Langkah Instalasi

1. Clone Repository

```bash
git clone <repository-url>
cd rice-berapi
```

2. Install Dependencies

```bash
composer install
```

3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

4. Konfigurasi Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rice_berapi
DB_USERNAME=root
DB_PASSWORD=
```

5. Buat Database

```sql
CREATE DATABASE rice_berapi;
```

6. Jalankan Migration & Seeder

```bash
php artisan migrate
php artisan db:seed
```

7. Setup Storage Link

```bash
php artisan storage:link
```

8. Jalankan Aplikasi

```bash
php artisan serve
```

Akses aplikasi di `http://localhost:8000`


## Fitur Keamanan

- Middleware Auth - Proteksi halaman yang memerlukan login
- Middleware Admin - Akses admin panel hanya untuk role admin
- CSRF Protection - Semua form dilindungi CSRF token Laravel
- Password Hashing - Bcrypt untuk enkripsi password
- Input Validation - Validasi semua input dari user
- File Upload Validation - Validasi type (image only), size (max 2MB), dan extension
- Authorization Check - User hanya bisa akses pesanan mereka sendiri
- SQL Injection Prevention - Eloquent ORM untuk query aman

## Deployment

### Production Checklist

1. Environment Configuration

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

2. Optimization Commands

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

3. File Permissions

```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

4. Setup proper web server configuration (Apache/Nginx)
5. Enable HTTPS dengan SSL certificate
6. Configure document root ke `/public`

## Key Routes

### Public Routes

- `/` - Landing page
- `/login` - Login page
- `/register` - Register page
- `/menu` - Product catalog
- `/menu/{id}` - Product detail

### User Routes (Auth Required)

- `/cart` - Shopping cart
- `/checkout` - Checkout page
- `/orders` - Order history
- `/orders/{id}` - Order detail dengan upload bukti transfer
- `/orders/{id}/invoice` - Preview invoice
- `/orders/{id}/invoice/download` - Download PDF
- `/orders/{id}/upload-proof` - POST upload bukti transfer
- `/notifications` - Notification list

### Admin Routes (Admin Only)

- `/admin/dashboard` - Admin dashboard
- `/admin/products` - Product management
- `/admin/orders` - Order management
- `/admin/orders/{id}/confirm-payment` - Confirm payment
- `/admin/reviews` - Review moderation

## Troubleshooting

### Storage Link Issue

```bash
php artisan storage:link
```

Jika error "symbolic link already exists":

```bash
rm public/storage
php artisan storage:link
```

### PDF Generation Error

Pastikan DomPDF terinstall:

```bash
composer require barryvdh/laravel-dompdf
```

### File Upload Failed

Check permissions:

```bash
chmod -R 775 storage/app/public
```

### Migration Error

Reset database:

```bash
php artisan migrate:fresh --seed
```

## License

Dibangun dengan Laravel framework yang berlisensi [MIT license](https://opensource.org/licenses/MIT).

---

**Developed for Rice Berapi UMKM**

Version 1.0.0 - Final Release
