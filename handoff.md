# Lentera App — Project Handoff

> **Status:** Concept / Architecture Planning
> **Purpose:** Context handoff for further product, architecture, and development analysis
> **Primary Goal:** Build a reusable modular business application foundation for Indonesian UMKM.

---

## 1. Project Overview

**Lentera App** adalah konsep **modular business operating system** untuk UMKM.

Lentera bukan ditujukan sebagai satu aplikasi yang memaksakan fitur yang sama untuk semua bisnis. Sebaliknya, Lentera menyediakan **satu fondasi aplikasi** yang dapat dikonfigurasi berdasarkan kebutuhan dan workflow setiap jenis usaha.

Prinsip utama:

> **Satu fondasi. Banyak kemungkinan. Tumbuh sesuai kebutuhan bisnis.**

Contoh konfigurasi:

```text
Lentera Resto
= Core + POS + Inventory + Reports + Restaurant

Lentera Printing
= Core + CRM + Inventory + Reports + Printing

Lentera Laundry
= Core + Customer + Reports + Laundry

Lentera Retail
= Core + POS + Inventory + Supplier + Reports + Retail
```

Tujuan akhirnya adalah membuat pengembangan aplikasi bisnis baru semakin **cepat, reusable, maintainable, dan ekonomis**, tanpa menghilangkan kemampuan untuk menyesuaikan workflow spesifik bisnis.

---

# 2. Core Product Thesis

Lentera tidak seharusnya diposisikan sebagai:

> "POS yang lebih murah."

Dan tidak seharusnya menjual teknologi seperti:

> "Modular Monolith + Micro-Frontend."

Pengguna UMKM tidak membeli arsitektur.

Mereka membeli solusi untuk masalah operasional seperti:

* transaksi,
* stok,
* pelanggan,
* produksi,
* laporan,
* workflow,
* pembayaran,
* dan kebutuhan bisnis lainnya.

Positioning konseptual yang lebih tepat:

> **"Sistem bisnis yang mengikuti cara kerja usaha Anda."**

Atau:

> **"Mulai dari kebutuhan sekarang, tambahkan kemampuan ketika bisnis berkembang."**

---

# 3. Architecture Philosophy

Lentera menggunakan:

> **Modular Monolith first, extensibility later.**

Bukan:

> Microservices first.

Semua bagian pada tahap awal tetap berada dalam:

```text
1 repository
1 backend
1 frontend
1 database
1 deployment
```

Modularitas diwujudkan melalui:

* domain boundaries,
* folder boundaries,
* service boundaries,
* module contracts,
* permission boundaries,
* event boundaries.

Tidak perlu memecah aplikasi menjadi banyak service hanya demi terlihat scalable.

---

# 4. Architecture Principle

Prinsip utama:

## Structure Early, Abstract Late

### Structure Early

Siapkan boundary sejak awal:

```text
Core
Modules
Verticals
Shared
```

agar codebase tidak perlu direstrukturisasi besar ketika vertical bisnis mulai stabil.

### Abstract Late

Jangan langsung membangun:

```text
Plugin marketplace
Dynamic plugin loader
Dependency resolver
Third-party SDK
Microservices
Micro-frontends
```

Abstraksi kompleks hanya dibuat ketika kebutuhan nyata muncul.

---

# 5. High-Level Architecture

```text
                         LENTERA APP
                              │
                    ┌─────────▼─────────┐
                    │   BUSINESS CORE   │
                    │                   │
                    │ Auth              │
                    │ User              │
                    │ Business          │
                    │ Permission        │
                    │ Settings          │
                    │ Customer          │
                    └─────────┬─────────┘
                              │
                  SHARED BUSINESS MODULES
                              │
             ┌────────────────┼────────────────┐
             │                │                │
            POS          INVENTORY            CRM
             │                │                │
             └────────────────┼────────────────┘
                              │
                     VERTICAL EXTENSIONS
                              │
       ┌──────────┬───────────┼──────────┬──────────┐
       │          │           │          │          │
    Restaurant  Printing    Laundry    Retail    Other
```

---

# 6. Core

Core berisi capability yang relatif universal untuk semua bisnis.

```text
Core
├── Auth
├── User
├── Business / Organization
├── Permission
├── Settings
└── Audit
```

Core tidak boleh mengetahui detail bisnis seperti:

* kitchen,
* laundry workflow,
* printing production,
* barcode retail,

kecuali konsep tersebut benar-benar universal.

---

# 7. Horizontal Modules

Horizontal modules adalah capability yang dapat digunakan lintas industri.

```text
Modules
├── POS
├── Inventory
├── CRM
├── Expense
├── Reports
└── Notifications
```

Contoh:

### POS

```text
POS
├── Sale
├── SaleItem
├── Payment
├── Receipt
└── Transaction History
```

### Inventory

```text
Inventory
├── Product
├── Stock
├── StockMovement
├── StockAdjustment
└── Warehouse
```

### CRM

```text
CRM
├── Customer
├── Customer History
├── Notes
└── Segmentation
```

---

# 8. Vertical Modules

Vertical modules berisi kebutuhan yang benar-benar spesifik terhadap jenis usaha.

Contoh:

## Restaurant

```text
Restaurant
├── Menu
├── Modifier
├── Recipe
├── Table
├── Order
└── Kitchen
```

## Printing

```text
Printing
├── Quotation
├── Order
├── Print Job
├── Design/File
├── Material
├── Production
├── Finishing
└── Pickup/Delivery
```

## Laundry

```text
Laundry
├── Service Type
├── Weight
├── Pricing
├── Order
├── Washing
├── Drying
├── Ironing
├── Ready
└── Pickup
```

## Retail

```text
Retail
├── Product
├── SKU
├── Barcode
├── Stock
├── Purchase
├── Supplier
└── Sale
```

---

# 9. Horizontal vs Vertical Rule

Jangan menduplikasi konsep universal hanya karena workflow-nya berbeda.

Contoh buruk:

```text
RestaurantCustomer
LaundryCustomer
PrintingCustomer
RetailCustomer
```

Lebih baik:

```text
Customer
```

dengan vertical-specific behavior jika memang diperlukan.

Prinsip:

> **Core menyimpan konsep universal. Vertical menyimpan perilaku khusus.**

---

# 10. Workflow as a First-Class Concept

Salah satu potensi kekuatan Lentera adalah kemampuan merepresentasikan workflow bisnis.

Contoh:

### Restaurant

```text
DRAFT
→ CONFIRMED
→ PREPARING
→ READY
→ COMPLETED
```

### Laundry

```text
RECEIVED
→ WASHING
→ DRYING
→ IRONING
→ READY
→ PICKED_UP
```

### Printing

```text
QUOTATION
→ CONFIRMED
→ DESIGN
→ PRODUCTION
→ FINISHING
→ READY
→ DELIVERED
```

### Retail

```text
CART
→ PAID
→ COMPLETED
```

Potential future abstraction:

```text
Workflow
├── States
├── Transitions
├── Permissions
├── Actions
└── Notifications
```

Namun workflow engine generik **tidak perlu dibangun pada MVP** sebelum kebutuhan nyata teridentifikasi.

---

# 11. Recommended Laravel Architecture

Lentera akan menggunakan Laravel sebagai backend.

Prinsip penting:

> **Laravel conventions as physical structure, domain boundaries as logical structure.**

Jangan terlalu cepat mengubah Laravel menjadi framework baru.

Recommended structure:

```text
app/
├── Console/
├── Exceptions/
│
├── Http/
│   ├── Controllers/
│   │   ├── Core/
│   │   ├── Modules/
│   │   │   ├── POS/
│   │   │   ├── Inventory/
│   │   │   ├── CRM/
│   │   │   └── Reports/
│   │   └── Verticals/
│   │       ├── Restaurant/
│   │       ├── Printing/
│   │       ├── Laundry/
│   │       └── Retail/
│   │
│   ├── Middleware/
│   └── Requests/
│
├── Models/
│   ├── Core/
│   ├── Modules/
│   │   ├── POS/
│   │   ├── Inventory/
│   │   ├── CRM/
│   │   └── Reports/
│   └── Verticals/
│       ├── Restaurant/
│       ├── Printing/
│       ├── Laundry/
│       └── Retail/
│
├── Services/
│   ├── Core/
│   ├── Modules/
│   │   ├── POS/
│   │   ├── Inventory/
│   │   ├── CRM/
│   │   └── Reports/
│   └── Verticals/
│       ├── Restaurant/
│       ├── Printing/
│       ├── Laundry/
│       └── Retail/
│
├── Policies/
├── Providers/
│   ├── AppServiceProvider.php
│   └── LenteraServiceProvider.php
│
└── Support/
    ├── Enums/
    ├── DTOs/
    ├── Contracts/
    └── Helpers/
```

---

# 12. Frontend Structure

Recommended stack:

**Vue 3 + TypeScript + Vite + Tailwind CSS**

Structure:

```text
resources/js/
│
├── core/
│   ├── auth/
│   ├── user/
│   ├── business/
│   ├── permission/
│   └── settings/
│
├── modules/
│   ├── pos/
│   ├── inventory/
│   ├── crm/
│   ├── expense/
│   └── reports/
│
├── verticals/
│   ├── restaurant/
│   ├── printing/
│   ├── laundry/
│   └── retail/
│
└── shared/
    ├── components/
    ├── layouts/
    ├── composables/
    └── utils/
```

Shared UI menggunakan satu Design System.

Contoh:

```text
shared/components/
├── Button
├── Input
├── Modal
├── Table
├── DataTable
├── Form
├── Badge
└── StatusBadge
```

Vertical hanya memiliki UI yang memang spesifik.

---

# 13. Full Project Structure

Target architecture:

```text
lentera/
│
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Core/
│   │   │   ├── Modules/
│   │   │   └── Verticals/
│   │   ├── Middleware/
│   │   └── Requests/
│   │
│   ├── Models/
│   │   ├── Core/
│   │   ├── Modules/
│   │   └── Verticals/
│   │
│   ├── Services/
│   │   ├── Core/
│   │   ├── Modules/
│   │   └── Verticals/
│   │
│   ├── Policies/
│   ├── Providers/
│   └── Support/
│
├── bootstrap/
│
├── config/
│   ├── lentera.php
│   ├── modules.php
│   └── permissions.php
│
├── database/
│   ├── factories/
│   ├── migrations/
│   │   ├── core/
│   │   ├── modules/
│   │   │   ├── pos/
│   │   │   ├── inventory/
│   │   │   ├── crm/
│   │   │   └── reports/
│   │   └── verticals/
│   │       ├── restaurant/
│   │       ├── printing/
│   │       ├── laundry/
│   │       └── retail/
│   └── seeders/
│
├── resources/
│   ├── js/
│   │   ├── core/
│   │   ├── modules/
│   │   ├── verticals/
│   │   └── shared/
│   ├── css/
│   └── views/
│
├── routes/
│   ├── web.php
│   ├── api.php
│   ├── core.php
│   ├── modules.php
│   └── verticals.php
│
├── storage/
├── tests/
│   ├── Feature/
│   │   ├── Core/
│   │   ├── Modules/
│   │   └── Verticals/
│   └── Unit/
│       ├── Core/
│       ├── Modules/
│       └── Verticals/
│
├── .env
├── composer.json
├── package.json
├── vite.config.js
└── README.md
```

This is a **target structure**. Empty directories do not need to be fully implemented.

---

# 14. Dependency Rules

Folder structure alone does not make a modular architecture.

Lentera should enforce these logical rules:

```text
CORE
  ↑
  │
MODULES
  ↑
  │
VERTICALS
```

More explicitly:

### Core

Can be consumed by:

* Modules
* Verticals

### Modules

Can use:

* Core
* other modules through explicit contracts/services/events

### Verticals

Can use:

* Core
* Modules

But should not directly manipulate another module's internal implementation.

Avoid:

```text
Restaurant → direct database access to Printing

POS → direct access to Inventory internal tables

Controller → complex business logic

Vertical → modify Core for one special case
```

Prefer:

```text
POS
 ↓
InventoryService
 ↓
StockMovement
```

or eventually:

```text
POS
 ↓
SaleCompleted
 ↓
Inventory
 ↓
StockDeducted
```

---

# 15. Technology Stack

Recommended initial stack:

| Layer           | Technology            |
| --------------- | --------------------- |
| Backend         | Laravel               |
| Frontend        | Vue 3                 |
| Language        | TypeScript + PHP      |
| Build           | Vite                  |
| Styling         | Tailwind CSS          |
| Database        | PostgreSQL            |
| Auth            | Laravel Sanctum       |
| State           | Pinia                 |
| API             | REST                  |
| Testing         | Pest/PHPUnit + Vitest |
| Dev environment | Docker Compose        |
| Version control | Git + GitHub          |
| CI/CD           | GitHub Actions        |
| Deployment      | VPS                   |
| Web Server      | Nginx                 |
| Cache/Queue     | Redis when needed     |

The stack should remain intentionally boring and maintainable.

---

# 16. Technologies Explicitly Deferred

Do not introduce these simply because they are technically attractive:

```text
Microservices
Micro-frontends
Kubernetes
GraphQL
Kafka / complex event broker
Plugin marketplace
Third-party plugin SDK
Native mobile application
Complex billing infrastructure
Advanced dynamic loading
```

They should only be introduced when a concrete problem justifies them.

Principle:

> **Architecture should follow pain, not imagination.**

---

# 17. Module Contract — Future Direction

Once multiple modules have proven stable, formalize a module contract.

Potential structure:

```text
Module
├── Manifest
├── Version
├── Dependencies
├── Routes
├── Permissions
├── Database Migration
├── Events
├── Services
└── UI
```

Example conceptual manifest:

```json
{
  "id": "inventory",
  "version": "1.0.0",
  "requires": {
    "core": ">=1.0"
  },
  "permissions": [
    "inventory.read",
    "inventory.write"
  ]
}
```

Do not build a full plugin system until actual reuse demands it.

---

# 18. Roadmap

## Phase 0 — Foundation

Build:

* Auth
* User
* Role
* Permission
* Business/Organization
* Settings
* Audit Log
* Shared UI components

Output:

```text
Lentera Core v0.1
```

---

## Phase 1 — POS MVP

Build:

* Product
* Cart
* Checkout
* Payment
* Receipt
* Transaction History
* Basic Stock Deduction

Goal:

> First genuinely usable business product.

---

## Phase 2 — Inventory

Build:

* Product
* Category
* Unit
* Stock
* Stock Adjustment
* Stock Movement
* Low Stock

---

## Phase 3 — Reports

Build:

* Sales
* Product
* Stock
* Profit
* Daily/Monthly Summary

---

## Phase 4 — CRM

Build:

* Customer
* Purchase History
* Notes
* Basic Segmentation

---

## Phase 5 — Modularization

After real user validation:

* formal module boundaries,
* module contracts,
* dependencies,
* permissions,
* events,
* migrations.

---

## Phase 6 — Module Manager

Potential features:

```text
Enable
Disable
Install
Update
```

Do not implement this before there are enough modules to justify it.

---

## Phase 7 — Multi-Tenant

Potential model:

```text
Lentera
├── Business A
├── Business B
└── Business C
```

Initial isolation can use:

```text
business_id
```

rather than separate databases per tenant.

---

## Phase 8 — Commercialization

Potential:

```text
Starter
Business
Custom
```

Plans can control:

* available modules,
* users,
* usage,
* features,
* business configuration.

---

# 19. Vertical Strategy

Do not develop all verticals simultaneously.

Candidate priorities:

1. **Printing / Packaging**
2. **Retail**
3. **F&B / Restaurant**
4. **Laundry**
5. **Workshop / Service**

Printing is particularly interesting as a candidate because it has a richer workflow than ordinary POS:

```text
Customer
→ Quotation
→ Order
→ Job
→ Material
→ Production
→ Finishing
→ Delivery
→ Payment
```

This makes Printing a potentially useful stress test for whether Lentera's modular architecture can handle real-world business workflows.

---

# 20. Validation Strategy

The correct direction is:

```text
Customer
 ↓
Real Problem
 ↓
Small Solution
 ↓
Observe Usage
 ↓
Find Reusable Pattern
 ↓
Extract Module
 ↓
Improve Core
```

Not:

```text
Build Framework
 ↓
Build Many Modules
 ↓
Search for Customers
```

LenteraStack should emerge naturally from repeated product requirements.

---

# 21. Key Architectural Decision

The most important decision from this discussion:

> **Prepare the folder/domain structure from day one, but delay sophisticated plugin abstraction.**

This prevents expensive future refactoring while avoiding premature engineering.

In short:

```text
Structure Early
+
Abstract Late
```

The folder boundaries should already anticipate:

```text
Core
Modules
Verticals
Shared
```

but implementation complexity should grow only when actual use cases demand it.

---

# 22. Current Strategic Thesis

Lentera should not compete primarily as:

> "another cheap POS."

Instead, it should aim toward:

> **A configurable business operating system that adapts to the workflow of different UMKM business types.**

The long-term evolution could be:

```text
Business App
      ↓
Reusable Modules
      ↓
Configurable Business Application
      ↓
Business Operating System
      ↓
Potential Ecosystem
```

The ecosystem/marketplace is a possible future, not an MVP requirement.

---

# 23. Guiding Principle

The most important principle for the project:

> **Jangan membangun LenteraStack agar bisa membuat Lentera App. Bangun Lentera App sampai pola yang berulang memaksa kita menciptakan LenteraStack.**

Supporting principle:

> **Structure early. Abstract late. Validate continuously.**

---

# 24. Immediate Next Step

The recommended next development task is **not** building the plugin system.

Start with:

```text
1. Laravel project
2. Vue + TypeScript + Vite
3. PostgreSQL
4. Authentication
5. Business/Organization
6. User + Role + Permission
7. Shared Design System
8. POS MVP
9. Basic Inventory
10. Test with real UMKM workflow
```

After real usage reveals repeated patterns, refine the module boundaries and only then formalize Lentera's module architecture.
