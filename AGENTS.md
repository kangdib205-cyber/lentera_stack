# AGENTS.md

# Lentera — AI Session Context

## Aturan Ketergantungan

**Wajib dan non-negotiable:**

```text
Core ← Modules ← Verticals
```

* **Modules** boleh menggunakan **Core** dan module lain **hanya melalui Service/Event**. Module tidak boleh mengakses tabel internal module lain secara langsung.
* **Verticals** boleh menggunakan **Core + Modules**, tetapi **tidak boleh mengubah Core** untuk kebutuhan khusus vertical.
* Dilarang melakukan akses langsung ke database internal module lain.

Contoh yang **dilarang**:

```text
Restaurant → direct DB access ke Printing
POS        → akses tabel internal Inventory
```

## Struktur Folder

Struktur domain aktif:

```text
app/{Http,Models,Services}/{Core,Modules,Verticals}/...
routes/{core.php,modules/*.php,verticals/*.php}
```

Namespace harus mengikuti struktur domain. Contoh:

```text
app/Models/Modules/POS/Sale.php
→ App\Models\Modules\POS\Sale
```

Kode baru harus ditempatkan pada folder domain yang sesuai:

```text
Core/
Modules/
Verticals/
```

Hindari menambahkan kode domain baru langsung di `app/` root.

## Status Implementasi

Lentera adalah **modular business operating system untuk UMKM Indonesia** dengan stack:

* Laravel 13
* PHP ^8.3
* Vue 3
* Vite
* Tailwind CSS 4
* Arsitektur **modular monolith**

Sebagian besar domain directory saat ini masih hanya berisi `.gitkeep`. Implementasi yang sudah berjalan terutama adalah migration default Laravel dan **POS module**.

### Fase MVP Saat Ini

```text
Phase 1 Foundation
```

> Update bagian ini secara manual saat fase MVP berubah.

## Yang Belum Boleh Dibangun

Fitur berikut **jangan dibangun pada fase saat ini**:

* Plugin marketplace
* Module manager
* Multi-tenant
* Microservices
* Payment gateway asli
* Generic workflow engine

## Konvensi Domain & Database

### Naming

* Nama tabel menggunakan **snake_case plural**.
* Tabel POS menggunakan prefix `pos_`.

Contoh:

```text
pos_products
pos_sales
pos_sale_items
pos_payments
```

Model POS harus menetapkan `$table` secara eksplisit.

### Service & Controller

* Gunakan **service class per domain**.
* Controller harus tetap tipis.
* Business logic utama ditempatkan di service/domain layer.

### Module Baru

Setiap module baru minimal memiliki:

```text
migration
model
service
controller
route
```

Semua file harus ditempatkan pada folder domain masing-masing.

## Arsitektur Antar-Domain

Aturan dependensi utama:

```text
Verticals → Modules → Core
```

Implikasinya:

* Vertical boleh bergantung pada Module dan Core.
* Module boleh bergantung pada Core.
* Module tidak boleh mengakses internals module lain secara langsung.
* Cross-module interaction harus menggunakan **Service** atau **Event**.

### Contoh Integrasi yang Benar

```text
POS → Inventory Service
Restaurant → Printing Service
```

### Contoh Integrasi yang Salah

```text
POS → query langsung tabel internal Inventory
Restaurant → query langsung tabel internal Printing
```

## Routing

File berikut tersedia di repository:

```text
routes/api.php
routes/core.php
routes/modules.php
routes/verticals.php
```

Namun, file-file tersebut **belum otomatis dimuat**.

Saat ini `bootstrap/app.php` hanya mendaftarkan:

```text
web.php
console.php
```

Karena itu, route baru pada file domain harus terlebih dahulu didaftarkan melalui `withRouting()` atau menggunakan `loadRoutesFrom()` pada provider yang sesuai.

## Perintah Utama

### Scope & YAGNI Check

- [ ] Jangan menambahkan feature hanya karena dianggap best practice.
- [ ] Setiap feature baru harus memiliki alasan bisnis atau kebutuhan teknis yang jelas.
- [ ] Jangan mengimplementasikan infrastructure sebelum ada consumer yang membutuhkannya.
- [ ] Jangan membuat abstraction/generic system untuk kebutuhan yang belum muncul.
- [ ] Prioritaskan penyelesaian flow MVP yang sedang aktif dibanding hardening fitur yang belum digunakan.
- [ ] Jika menemukan improvement di luar scope, catat sebagai recommendation/backlog, jangan langsung implementasikan.
- [ ] Sebelum mengerjakan recommendation, jelaskan dependency dan alasan kenapa feature tersebut dibutuhkan sekarang.
- [ ] Hindari speculative implementation, terutama untuk authentication, permissions, multi-tenancy, plugin system, workflow engine, dan infrastructure.


### Recommendation vs Implementation

Agent harus membedakan:

1. **Required now**
   - Dibutuhkan agar feature yang sedang dikerjakan berfungsi atau aman digunakan.

2. **Recommended next**
   - Masuk akal untuk pekerjaan berikutnya, tetapi tidak menghalangi pekerjaan saat ini.

3. **Future / Backlog**
   - Valid secara teknis tetapi belum dibutuhkan oleh MVP.

Jangan mengubah item kategori 2 atau 3 menjadi implementation tanpa instruksi eksplisit.

Jika pekerjaan saat ini sudah selesai dan test lulus, jangan otomatis memperluas scope.
Laporkan recommendation sebagai backlog dan tunggu instruksi.

### Setup Baru

```bash
composer run setup
```

Perintah ini menjalankan proses setup utama:

```text
composer install
copy .env
key:generate
migrate
npm install
vite build
```

### Development

Full development stack:

```bash
composer dev
```

Mencakup:

* application server
* queue worker
* Pail logs
* Vite

Backend saja:

```bash
php artisan serve
```

Frontend saja:

```bash
npm run dev
```

### Testing

```bash
composer test
```

Setara dengan menjalankan:

```text
config:clear
artisan test
```

Test menggunakan **in-memory SQLite** melalui `phpunit.xml`.

Development lokal menggunakan:

```text
database/database.sqlite
```

### Formatting

```bash
vendor/bin/pint
```

## Known Issues & Gotchas

### PHPUnit / `mbstring`

Build PHP 8.4 pada environment saat ini tidak memiliki extension `mbstring`.

Akibatnya:

```bash
php artisan test
```

belum dapat dijalankan sampai extension `mbstring` diaktifkan.

### Homepage

Route:

```text
Route::get('/')
```

menggunakan `HomeController`, yang melakukan query ke:

```text
App\Models\Post
```

Namun migration `posts` belum tersedia.

Akibatnya, homepage saat ini berpotensi menghasilkan:

```text
HTTP 500
```

### Authentication

Belum ada package authentication API seperti:

```text
Sanctum
Passport
```

Jangan mengasumsikan middleware atau guard berikut tersedia:

```text
auth:api
```

Authentication harus diverifikasi terlebih dahulu dari implementasi aktual sebelum digunakan.

## Source of Truth

File berikut:

```text
handoff.md
plan.md
learn.md
learn-module/
```

menjelaskan target architecture dan sebagian isinya masih **aspirational**.

Saat terjadi perbedaan antara dokumentasi dan implementasi:

> **Trust executable code over documentation.**

Gunakan kode yang benar-benar berjalan sebagai source of truth.

## Git & Branch Convention

Konvensi branch:

```text
feat/<area>-<short>
fix/<area>-<short>
```

Default branch:

```text
main
```
