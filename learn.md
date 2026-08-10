# Struktur Folder Laravel

Struktur folder Laravel dirancang untuk memisahkan logika, konfigurasi, aset, dan data runtime.

## Root
- `artisan` - CLI Laravel.
- `composer.json` - deklarasi dependensi PHP.
- `package.json` - dependensi JavaScript/Vite.
- `phpunit.xml` - konfigurasi pengujian.
- `README.md` - dokumentasi proyek.

## app/
- `Models/` - model Eloquent dan representasi data.
- `Http/Controllers/` - controller yang menangani permintaan HTTP.
- `Providers/` - service provider aplikasi.
- `User.php` - contoh model pengguna.

## bootstrap/
- `app.php` - bootstrap framework aplikasi.
- `cache/` - cache bootstrap dan konfigurasi paket.

## config/
- Konfigurasi aplikasi seperti `app.php`, `auth.php`, `database.php`, `mail.php`, `queue.php`, `services.php`, dan `session.php`.

## database/
- `migrations/` - file migrasi database.
- `seeders/` - data seed awal.
- `factories/` - factory model untuk pengujian.

## public/
- `index.php` - titik masuk aplikasi web.
- `robots.txt` - aturan perayap.
- `build/` - aset frontend terkompilasi (diabaikan oleh git).

## resources/
- `views/` - template Blade.
- `js/` dan `css/` - sumber asset frontend.

## routes/
- `web.php` - rute web.
- `console.php` - rute konsol/artisan.

## storage/
- Menyimpan data runtime seperti log, cache, sesi, dan file yang diunggah.
- `app/`, `framework/`, `logs/`, dan `testing/` biasanya diabaikan oleh git.

## tests/
- `Feature/` - pengujian fungsional.
- `Unit/` - pengujian unit.
- `TestCase.php` - dasar pengujian.

## vendor/
- Dependensi PHP pihak ketiga yang diinstal oleh Composer.

## framework/
- Kode inti Laravel yang disalin ke dalam proyek.

## storage/logs dan storage/framework
- `storage/logs` - log aplikasi.
- `storage/framework` - cache view, session, dan file runtime lain.

> Catatan: Folder `app/` adalah inti aplikasi. Jangan memasukkannya ke `.gitignore` jika Anda ingin menyimpan kode aplikasi.
