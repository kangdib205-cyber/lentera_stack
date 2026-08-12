# 02 — Arsitektur dan Konvensi

Ringkasan singkat arsitektur yang digunakan oleh proyek (lihat `handoff.md` untuk detail lengkap):

- Modular Monolith: satu repo dengan boundary domain `Core`, `Modules`, `Verticals`.
- Folder-level conventions: letakkan controllers, models, services sesuai domain.
- Routes: pisahkan file rute per domain ketika fitur bertumbuh (`core.php`, `modules.php`, `verticals.php`).
- Migrations: pertimbangkan struktur `migrations/core`, `migrations/modules`, `migrations/verticals`.

Penamaan & konvensi:
- Service classes berada di `app/Services` dan menerima dependensi via constructor.
- Contracts/interfaces diletakkan di `app/Support/Contracts`.
- DTO di `app/Support/DTOs`.

Testing:
- Feature tests menargetkan alur bisnis di `tests/Feature/{Core,Modules,Verticals}`.
- Unit tests untuk service/utility di `tests/Unit`.
