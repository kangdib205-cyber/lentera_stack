# 01 — Setup Lingkungan Pengembangan

Langkah cepat untuk menyiapkan lingkungan pengembangan lokal:

1. Pastikan PHP, Composer, Node.js (dengan npm) dan SQLite/Postgres terinstall.

2. Install dependensi PHP:

```bash
composer install
```

3. Install dependensi JS dan bangun aset:

```bash
npm install
npm run build
```

4. Salin file environment dan sesuaikan:

```bash
cp .env.example .env
php artisan key:generate
```

5. Jalankan migrasi (SQLite default untuk dev kecil):

```bash
php artisan migrate
```

6. Jalankan server lokal:

```bash
php artisan serve
```

Catatan: Jika menggunakan Docker, gunakan konfigurasi lokal yang disarankan di dokumentasi proyek.
