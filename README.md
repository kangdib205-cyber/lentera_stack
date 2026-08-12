# Lentera App

> **Status:** Concept / Architecture Planning  
> **Purpose:** Modular business operating system foundation for Indonesian UMKM  
> **Philosophy:** One foundation. Many possibilities. Grow according to business needs.

## About Lentera

Lentera App is a **modular business operating system** designed for Indonesian SMEs (UMKM). Unlike traditional one-size-fits-all business software, Lentera provides a unified foundation that can be configured and extended based on the specific needs and workflows of different business types.

### Core Principles

**Satu fondasi. Banyak kemungkinan. Tumbuh sesuai kebutuhan bisnis.**

- **One Foundation**: A unified backend with shared business logic (Core)
- **Many Possibilities**: Extensible through Horizontal Modules and Vertical Extensions
- **Scalable Growth**: Start with essential features, add capabilities as business grows

### Example Configurations

```
Lentera Resto     = Core + POS + Inventory + Reports + Restaurant
Lentera Printing  = Core + CRM + Inventory + Reports + Printing
Lentera Laundry   = Core + Customer + Reports + Laundry
Lentera Retail    = Core + POS + Inventory + Supplier + Reports + Retail
```

## Architecture

Lentera follows a **Modular Monolith** approach with clear domain boundaries:

### High-Level Structure

```
LENTERA APP
    ↓
BUSINESS CORE (Auth, User, Business, Permission, Settings, Audit)
    ↓
HORIZONTAL MODULES (POS, Inventory, CRM, Reports, Notifications)
    ↓
VERTICAL EXTENSIONS (Restaurant, Printing, Laundry, Retail, etc.)
```

### Three Layers

1. **Core** - Universal capabilities for all businesses
2. **Modules** (Horizontal) - Cross-industry features (POS, Inventory, CRM)
3. **Verticals** (Specialized) - Business-specific workflows and features

### Project Structure

```
lentera/
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
│   ├── Models/
│   │   ├── Core/
│   │   ├── Modules/
│   │   └── Verticals/
│   ├── Services/
│   │   ├── Core/
│   │   ├── Modules/
│   │   └── Verticals/
│   ├── Policies/
│   ├── Providers/
│   └── Support/
│       ├── Contracts/
│       ├── DTOs/
│       ├── Enums/
│       └── Helpers/
│
├── config/
│   ├── lentera.php
│   ├── modules.php
│   └── permissions.php
│
├── database/
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
│   ├── factories/
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
└── tests/
    ├── Feature/
    │   ├── Core/
    │   ├── Modules/
    │   └── Verticals/
    └── Unit/
        ├── Core/
        ├── Modules/
        └── Verticals/
```

## Technology Stack

### Backend
- **Framework**: Laravel 11+
- **Language**: PHP 8.3+
- **Database**: Supports MySQL, PostgreSQL
- **Authentication**: Laravel Sanctum/Passport
- **Job Queue**: Laravel Queues

### Frontend
- **Framework**: Vue 3
- **Language**: TypeScript
- **Build Tool**: Vite
- **Styling**: Tailwind CSS
- **State Management**: Pinia

## Key Architecture Concepts

### Core
Universal capabilities for all businesses:
- Authentication & Authorization
- User Management
- Business/Organization Setup
- Permission System
- Settings & Configuration
- Audit Logging

### Horizontal Modules
Cross-industry business features:

**POS** - Point of Sale  
- Sale transactions
- Items and SKUs
- Payment processing
- Receipt generation

**Inventory** - Stock Management
- Product catalog
- Stock tracking
- Stock movements
- Warehouse management

**CRM** - Customer Relationship
- Customer profiles
- Purchase history
- Notes and interaction tracking
- Customer segmentation

**Reports** - Business Analytics
- Sales reports
- Inventory insights
- Financial summaries

### Vertical Extensions
Business-specific features:

**Restaurant** - Menu, Orders, Kitchen workflow  
**Printing** - Quotations, Print jobs, Production, Finishing  
**Laundry** - Service types, Orders, Washing workflow  
**Retail** - Products, SKU, Barcode, Suppliers  

## Workflow as First-Class Concept

Each vertical implements business-specific workflows:

| Restaurant | Laundry | Printing | Retail |
|-----------|---------|----------|--------|
| DRAFT | RECEIVED | QUOTATION | CART |
| CONFIRMED | WASHING | CONFIRMED | PAID |
| PREPARING | DRYING | DESIGN | COMPLETED |
| READY | IRONING | PRODUCTION | |
| COMPLETED | READY | FINISHING | |
| | PICKED_UP | READY | |
| | | DELIVERED | |

## Development

For detailed architecture and development guidelines, see:
- [learn-module/](learn-module/) - Learning resources and exercises
- [handoff.md](handoff.md) - Project handoff and architecture decisions
- [learn.md](learn.md) - Project learning notes

## License

This project is licensed under the MIT License.
