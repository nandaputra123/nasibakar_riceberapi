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

## Fitur Keamanan

- Middleware Auth - Proteksi halaman yang memerlukan login
- Middleware Admin - Akses admin panel hanya untuk role admin
- CSRF Protection - Semua form dilindungi CSRF token Laravel
- Password Hashing - Bcrypt untuk enkripsi password
- Input Validation - Validasi semua input dari user
- File Upload Validation - Validasi type (image only), size (max 2MB), dan extension
- Authorization Check - User hanya bisa akses pesanan mereka sendiri
- SQL Injection Prevention - Eloquent ORM untuk query aman


---

**Developed for Rice Berapi UMKM**

Version 1.0.0 - Final Release
