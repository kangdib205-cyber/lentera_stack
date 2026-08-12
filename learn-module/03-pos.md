# 03 — Panduan Modul POS (Fiur Kasir)

Panduan ini menjelaskan cara merancang dan membuat modul POS (kasir) sebagai modul horizontal yang bisa dipakai oleh banyak vertical.

1) Struktur direktori

- `app/Models/Modules/POS` — model: `Product`, `Sale`, `SaleItem`, `Payment`.
- `app/Http/Controllers/Modules/POS` — controller: `POSController`, `CheckoutController`.
- `app/Services/Modules/POS` — logika domain (cart, pricing, discounts).
- `database/migrations/modules/pos` — migrasi domain POS.
- `resources/js/modules/pos` — komponen UI: `Cashier`, `Cart`, `Checkout`, `Receipt`.

2) Entitas utama (contoh singkat)

- `Product` (sku, name, price, stock)
- `Sale` (id, total, status, business_id, user_id)
- `SaleItem` (sale_id, product_id, qty, price)
- `Payment` (sale_id, amount, method)

3) API & Routes (ringkasan)

- Tambahkan route di `routes/modules.php` atau `routes/api.php`:

  - `GET /modules/pos/products` — list produk
  - `POST /modules/pos/cart` — tambah barang ke cart (session / db)
  - `POST /modules/pos/checkout` — proses pembayaran
  - `GET /modules/pos/{sale}` — detail nota

4) Service layer

- Implementasikan `CartService` di `app/Services/Modules/POS` untuk:
  - menambah/mengurangi item
  - menghitung subtotal, diskon, pajak
  - membuat `Sale` saat checkout dan handle stock deduction

5) Events

- Emit event `SaleCompleted` setelah checkout sukses.
- Consumer: `InventoryService` atau `StockMovement` untuk mengurangi stok.

6) Permissions

- Tambahkan permission minimal di `config/permissions.php`:
  - `pos.view`, `pos.checkout`, `pos.refund`

7) Migration contoh (ringkasan)

- Buat migration `create_pos_sales_table`, `create_pos_sale_items_table`, `create_pos_payments_table`, dan penambahan kolom stock pada `products`.

8) Frontend (UI)

- `resources/js/modules/pos/Cashier.vue` — tampilan kasir utama (produk, pencarian, cart sidebar).
- Gunakan Pinia store `pos/cart` untuk menyimpan state cart.
- Integrasi `@vite` untuk entry `resources/js/modules/pos/index.ts`.

9) Testing

- Feature test: `tests/Feature/Modules/POS/CheckoutTest.php` — skenario checkout lengkap.
- Unit test: `tests/Unit/Modules/POS/CartServiceTest.php` — bunga logic perhitungan.

10) Checklist implementasi

- [ ] Buat model & migration
- [ ] Buat service `CartService`
- [ ] Buat controller endpoints
- [ ] Buat frontend `Cashier` component
- [ ] Tambah permissions dan policies
- [ ] Tambah tests feature + unit
- [ ] Emit `SaleCompleted` event dan handler untuk inventory

11) Perintah scaffolding cepat

```bash
php artisan make:model Models/Modules/POS/Product -m
php artisan make:model Models/Modules/POS/Sale -m
php artisan make:controller Http/Controllers/Modules/POS/POSController --api
php artisan make:service Services/Modules/POS/CartService
php artisan make:test Feature/Modules/POS/CheckoutTest --unit
```

Catatan: `make:service` bukan perintah Laravel default; gunakan `make:command` atau buat file secara manual jika belum tersedia.

12) Latihan singkat (exercise)

- Implementasikan endpoint `GET /modules/pos/products` yang mengembalikan daftar produk terfilter.
- Implementasikan `CartService::addItem()` dan unit test untuknya.

Panduan ini dimaksudkan sebagai checklist operasional dan referensi cepat. Untuk detail implementasi, gunakan `learn-module/02-architecture.md` dan `handoff.md`.
