## Routine Session Checklist

Gunakan checklist ini pada setiap awal sesi dan sebelum menyelesaikan pekerjaan.

### Awal Session

- [ ] Baca `AGENTS.md` dan pahami aturan dependency `Core → Modules → Verticals`.
- [ ] Identifikasi fase MVP yang sedang aktif.
- [ ] Periksa status repository dan branch saat ini.
- [ ] Periksa perubahan lokal yang sudah ada sebelum melakukan perubahan baru.
- [ ] Identifikasi module/domain yang akan disentuh.
- [ ] Verifikasi apakah kebutuhan sudah sesuai dengan scope MVP.
- [ ] Pastikan pekerjaan tidak termasuk fitur yang sedang dilarang dibangun.
- [ ] Periksa implementasi aktual sebelum mengikuti dokumentasi yang bersifat aspirational.

### Sebelum Mengubah Code

- [ ] Tentukan layer yang tepat: `Core`, `Modules`, atau `Verticals`.
- [ ] Pastikan dependency mengikuti `Verticals → Modules → Core`.
- [ ] Pastikan tidak ada direct DB access ke internal module lain.
- [ ] Untuk cross-module interaction, gunakan Service/Event.
- [ ] Periksa model, migration, service, controller, dan route terkait sebelum membuat yang baru.
- [ ] Hindari membuat abstraction/generic framework yang belum diperlukan MVP.
- [ ] Pertahankan controller tetap tipis dan business logic di service/domain layer.

### Setelah Mengubah Code

- [ ] Periksa kembali file yang berubah.
- [ ] Jalankan formatter pada code yang relevan.
- [ ] Jalankan test yang relevan.
- [ ] Jika test gagal karena environment, bedakan antara **code failure** dan **environment failure**.
- [ ] Periksa route/model/migration yang baru atau berubah.
- [ ] Pastikan tidak ada dependency lintas module yang melanggar aturan.
- [ ] Pastikan tidak ada perubahan di luar scope pekerjaan.

### Sebelum Menutup Session

- [ ] Review diff akhir.
- [ ] Pastikan tidak ada perubahan yang tidak disengaja.
- [ ] Catat test/check yang berhasil dijalankan.
- [ ] Catat test/check yang tidak dapat dijalankan beserta alasannya.
- [ ] Catat known issue baru jika ditemukan.
- [ ] Pastikan dokumentasi hanya diperbarui jika memang mencerminkan kondisi aktual.
- [ ] Jangan mengklaim pekerjaan selesai jika verification yang relevan belum dilakukan.

### Prinsip Utama

> **Inspect → Plan → Change → Verify → Review**

Jangan langsung mengubah code sebelum memahami struktur dan dependency domain yang terkait.

## Session Log

### 2026-08-15 — Inisialisasi proyek dan dokumentasi dasar
- Menginisialisasi aplikasi Laravel dengan struktur dasar project dan konfigurasi awal.
- Menambahkan dokumentasi utama (`README.md`, `plan.md`, `AGENTS.md`) serta materi pembelajaran di `learn-module/`.
- Menetapkan arsitektur modular dan dependency rule `Core → Modules → Verticals`.
- Menyiapkan checklist sesi agar perubahan dan verifikasi terdokumentasi secara berulang.

### 2026-08-15 — Implementasi awal landing page
- Menambahkan `HomeController` untuk render home page dari Laravel.
- Menyempurnakan `resources/views/home.blade.php` menjadi tampilan Blade sederhana dengan fallback saat data kosong.
- Menyesuaikan `routes/web.php` agar home route berfungsi dengan view yang sesuai.
- Menyelesaikan struktur awal routing untuk project MVP.

### 2026-08-15 — Fondasi Core domain
- Membuat migration `2026_08_15_000001_create_core_foundation_tables.php` untuk tabel inti bisnis: `businesses`, `roles`, `permissions`, `business_settings`, `user_roles`, `role_permissions`, dan `audit_logs`.
- Menambahkan kolom tambahan pada `users` untuk `business_id`, `phone`, `is_active`, dan `last_login_at`.
- Menambahkan model inti di `app/Models/Core/` untuk business, permission, role, user-role, business setting, dan audit log.
- Memperbarui `app/Models/User.php` agar user terhubung ke `Business` dan `Role`, serta memiliki cast yang relevan.

### 2026-08-15 — Auth flow awal
- Menambahkan `app/Http/Controllers/Core/AuthController.php` sebagai controller autentikasi awal.
- Mengaktifkan route API auth di `routes/web.php` untuk `register`, `login`, `logout`, dan `user`.
- Menyiapkan fondasi auth multi-business dan role-based access di level core.

### 2026-08-16 — Verifikasi akhir yang sudah dilakukan
- Menjalankan `php artisan migrate --force` berhasil tanpa error.
- Menjalankan `php artisan test` berhasil dengan exit code `0`.
- Status code saat ini menunjukkan perubahan aktif pada route, model, migration, controller, view, dan dokumentasi sesuai dengan tahapan MVP.

### Catatan penting
- Dokumentasi di `plan.md` dan `learn-module/` sebagian bersifat aspirational; implementasi aktual di codebase lebih relevan sebagai referensi.
- Route root masih menggunakan pendekatan fallback sederhana, bukan data domain yang kompleks.
- Belum ada feature vertical/module lanjutan yang dibangun; fokus saat ini masih pada fondasi Core dan setup awal aplikasi.
