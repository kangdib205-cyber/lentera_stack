## Ringkasan Struktur Project (Lentera)

Dokumen ini menyelaraskan struktur folder proyek dengan spesifikasi arsitektur di `handoff.md`. Tujuannya: memberi panduan cepat untuk kontributor baru dan pengembang.

### Inti (root)
- `artisan`, `composer.json`, `package.json`, `README.md`, `vite.config.js`

### `app/`
Struktur domain-aware yang mengikuti pembagian Core, Modules, dan Verticals. Contoh subfolder penting:
- `Console/`, `Exceptions/`
- `Http/Controllers/{Core,Modules,Verticals}`, `Http/Middleware`, `Http/Requests`
- `Models/{Core,Modules,Verticals}`
- `Services/{Core,Modules,Verticals}`
- `Policies/`, `Providers/`, `Support/{Enums,DTOs,Contracts,Helpers}`

Catatan: `app/Providers/LenteraServiceProvider.php` direkomendasikan untuk provider proyek (bila belum ada).

### `bootstrap/`
- berisi `app.php` dan cache bootstrap di `bootstrap/cache`.

### `config/`
- konfigurasi aplikasi. Disarankan menambah `lentera.php`, `modules.php`, `permissions.php` untuk konfigurasi modular.

### `database/`
- `migrations/`, `factories/`, `seeders/`.
- Untuk modularitas, pertimbangkan subfolder migrasi: `migrations/core`, `migrations/modules`, `migrations/verticals`.

### `resources/`
- `views/` (Blade templates)
- `js/{core,modules,verticals,shared}` dan `css/` untuk sumber frontend.

### `routes/`
- `web.php`, `api.php`, dan file rute khusus domain seperti `core.php`, `modules.php`, `verticals.php` direkomendasikan.

### `storage/`
- runtime files: `app/`, `framework/`, `logs/`, `testing/` (umumnya diabaikan oleh Git).

### `tests/`
- `Feature/{Core,Modules,Verticals}`, `Unit/{Core,Modules,Verticals}`

### `vendor/`
- dependensi Composer (di-ignore oleh Git).

---

Lihat juga modul belajar: [learn-module](learn-module/README.md) untuk panduan pengembangan, setup, dan checklist tugas awal proyek.
