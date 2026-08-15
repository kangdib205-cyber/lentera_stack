# Lentera MVP Plan

> **Version**: 1.0  
> **Target**: Proof of Concept / Minimal Viable Product  
> **Timeline**: 6-8 weeks  
> **Primary Vertical**: Restaurant (POS + Kitchen)

---

## 1. MVP Scope

### What's Included

The MVP is a fully functional **Restaurant Point of Sale (POS) system** with:

1. **Core** - Essential business infrastructure
2. **Horizontal Modules** - POS and basic Inventory
3. **Vertical** - Restaurant-specific features (Menu, Orders, Kitchen workflow)
4. **Shared** - Design system and common UI components

### What's Excluded (Post-MVP)

- Multi-location support
- Advanced CRM and customer loyalty programs
- Complex reporting and analytics
- Mobile application
- Payment gateway integration
- Kitchen display system (KDS) hardware support
- Printing/thermal printer integration
- Inventory forecasting
- Other verticals (Printing, Laundry, Retail)

---

## 2. Core Module (MVP Scope)

Essential business foundation capabilities:

### 2.1 Authentication & Authorization
- **Features**:
  - User registration and login (email + password)
  - Role-based access control (Owner, Manager, Cashier, Kitchen Staff)
  - Session management
  - Basic audit logging for critical actions
- **DB Tables**: `users`, `roles`, `role_user`, `audit_logs`
- **API Endpoints**:
  - `POST /api/auth/register`
  - `POST /api/auth/login`
  - `POST /api/auth/logout`
  - `GET /api/auth/user`

### 2.2 Business Setup
- **Features**:
  - Business profile (name, address, phone)
  - Basic settings (currency, timezone)
  - Logo/branding (optional for MVP)
- **DB Tables**: `businesses`, `business_settings`
- **API Endpoints**:
  - `GET /api/business`
  - `PUT /api/business`
  - `PUT /api/business/settings`

### 2.3 Permission System
- **Features**:
  - Role-based permissions
  - Permission checks on endpoints
  - UI visibility based on permissions
- **DB Tables**: `permissions`, `role_permissions`
- **Permissions to define**:
  - `view_dashboard`
  - `manage_menu`
  - `manage_inventory`
  - `process_sale`
  - `view_orders`
  - `manage_kitchen`
  - `view_reports`

### 2.4 User Management
- **Features**:
  - Create/edit/delete users
  - Assign roles
  - Reset password
- **DB Tables**: `users` (already defined)
- **API Endpoints**:
  - `GET /api/users`
  - `POST /api/users`
  - `PUT /api/users/{id}`
  - `DELETE /api/users/{id}`

---

## 3. Horizontal Modules (MVP Scope)

### 3.1 POS Module

**Purpose**: Handle sales transactions and payment processing

#### 3.1.1 Sale Transaction
- **Features**:
  - Create sale from menu items
  - Add/remove items from sale
  - Apply discount
  - Payment method selection
  - Receipt generation
  - Transaction history
- **DB Tables**:
  - `sales` (id, user_id, business_id, total, discount, payment_method, status, created_at)
  - `sale_items` (id, sale_id, menu_item_id, quantity, unit_price, subtotal)
  - `sale_payments` (id, sale_id, payment_method, amount)

#### 3.1.2 Payment Methods
- **Methods**: Cash, Card (simplified - no real gateway)
- **DB Tables**: `payment_methods`, `sale_payments`
- **No external payment gateway required for MVP**

#### 3.1.3 API Endpoints
- `POST /api/sales` - Create new sale
- `GET /api/sales/{id}` - Get sale details
- `PUT /api/sales/{id}/items` - Add/remove items
- `PUT /api/sales/{id}/discount` - Apply discount
- `POST /api/sales/{id}/complete` - Finalize sale
- `GET /api/sales` - List sales (with filters)
- `GET /api/sales/receipt/{id}` - Generate receipt

#### 3.1.4 UI Components
- Sale form with item selection
- Quantity adjuster
- Discount input
- Payment method selector
- Receipt preview

### 3.2 Inventory Module

**Purpose**: Track menu items and stock levels

#### 3.2.1 Product/Menu Item Management
- **Features**:
  - Create menu items with price
  - Categorize items (Appetizer, Main Course, Dessert, Beverage)
  - Set availability (available/unavailable)
  - Track cost (for profit calculation)
- **DB Tables**:
  - `menu_items` (id, business_id, name, description, category, price, cost, available, created_at)
  - `menu_categories` (id, business_id, name, sort_order)

#### 3.2.2 Stock Tracking (Basic)
- **Features**:
  - Track quantity on hand
  - Record stock movements (sales, manual adjustment)
  - Receive new stock
- **DB Tables**:
  - `stock_movements` (id, menu_item_id, type, quantity, notes, created_at)
  - `stock_levels` (id, menu_item_id, quantity_on_hand)

#### 3.2.3 API Endpoints
- `GET /api/menu-items` - List menu items
- `POST /api/menu-items` - Create menu item
- `PUT /api/menu-items/{id}` - Edit menu item
- `DELETE /api/menu-items/{id}` - Delete menu item
- `GET /api/inventory/stock` - Check stock levels
- `POST /api/inventory/stock-in` - Receive stock
- `POST /api/inventory/stock-adjustment` - Adjust stock

#### 3.2.4 UI Components
- Menu item list with search/filter
- Menu item form (create/edit)
- Stock management panel
- Stock level badges

---

## 4. Vertical Module: Restaurant

**Purpose**: Restaurant-specific features (Orders, Kitchen workflow, Table management)

### 4.1 Menu with Modifiers
- **Features**:
  - Menu items with optional modifiers (spicy level, cooking temperature)
  - Modifier groups (can be single or multiple select)
- **DB Tables**:
  - `modifier_groups` (id, menu_item_id, name, type: single|multiple)
  - `modifiers` (id, modifier_group_id, name, price_adjustment)

#### API Endpoints
- `GET /api/restaurant/menu` - Menu with modifiers
- `POST /api/restaurant/modifier-groups` - Create modifier group
- `POST /api/restaurant/modifiers` - Create modifier

### 4.2 Table Management
- **Features**:
  - Define tables (table number, capacity)
  - Dine-in vs Take-out orders
  - Assign order to table
- **DB Tables**:
  - `tables` (id, business_id, table_number, capacity, status)

#### API Endpoints
- `GET /api/restaurant/tables` - List tables
- `POST /api/restaurant/tables` - Create table
- `PUT /api/restaurant/tables/{id}` - Update table

### 4.3 Order Workflow
- **Features**:
  - Create order (Dine-in or Take-out)
  - Add items with modifiers
  - Order states: DRAFT → CONFIRMED → PREPARING → READY → COMPLETED
  - Kitchen receives orders
  - Mark items as ready
- **DB Tables**:
  - `orders` (id, business_id, table_id, order_type: dine_in|takeout, status, created_at, completed_at)
  - `order_items` (id, order_id, menu_item_id, quantity, modifiers_json, status: preparing|ready)
  - `order_payments` (id, order_id, sale_id) - Link to POS sale

#### Order Statuses
```
DRAFT (order being built)
  ↓
CONFIRMED (sent to kitchen)
  ↓
PREPARING (kitchen working)
  ↓
READY (waiting for customer)
  ↓
COMPLETED (customer received order)
```

#### API Endpoints
- `POST /api/restaurant/orders` - Create order
- `GET /api/restaurant/orders` - List orders
- `PUT /api/restaurant/orders/{id}` - Update order
- `POST /api/restaurant/orders/{id}/items` - Add items
- `PUT /api/restaurant/orders/{id}/items/{itemId}` - Update item
- `DELETE /api/restaurant/orders/{id}/items/{itemId}` - Remove item
- `POST /api/restaurant/orders/{id}/confirm` - Confirm order
- `PUT /api/restaurant/orders/{id}/items/{itemId}/status` - Update item status

### 4.4 Kitchen Display (Simple)
- **Features**:
  - Real-time order list for kitchen
  - Filter by status (preparing, ready)
  - Mark items as ready
  - Simple UI optimized for kitchen staff
- **UI**: Dedicated kitchen screen/view

---

## 5. Database Schema (MVP)

### Core Tables

```sql
-- Authentication & Authorization
users (id, business_id, name, email, password, phone, role, is_active)
roles (id, name) -- Owner, Manager, Cashier, Kitchen
permissions (id, name)
role_permissions (id, role_id, permission_id)

-- Business
businesses (id, name, address, city, phone, timezone, currency)
business_settings (id, business_id, key, value)

-- Audit
audit_logs (id, user_id, action, model, model_id, changes, created_at)
```

### POS Module Tables

```sql
-- Sales
sales (id, business_id, user_id, total, discount, payment_method, status, notes, created_at, completed_at)
sale_items (id, sale_id, menu_item_id, quantity, unit_price, subtotal)
payment_methods (id, name) -- Cash, Card
```

### Inventory Module Tables

```sql
-- Menu Items
menu_items (id, business_id, name, description, category, price, cost, available, image_url, created_at)
menu_categories (id, business_id, name, sort_order)
stock_levels (id, menu_item_id, quantity_on_hand, last_updated)
stock_movements (id, menu_item_id, type, quantity, reference_id, notes, created_at)
```

### Restaurant Vertical Tables

```sql
-- Restaurant
tables (id, business_id, table_number, capacity, status)
orders (id, business_id, table_id, order_type, status, notes, created_at, completed_at)
order_items (id, order_id, menu_item_id, quantity, modifiers_json, status, prepared_at)
modifier_groups (id, menu_item_id, name, type)
modifiers (id, modifier_group_id, name, price_adjustment)

-- Link POS to Orders
order_payments (id, order_id, sale_id, linked_at)
```

---

## 6. Frontend Structure (MVP)

### Layouts
- **AuthLayout** - Login/register pages
- **DashboardLayout** - Sidebar navigation, top bar
- **KitchenLayout** - Full-screen kitchen display (minimal UI)

### Core Pages
- `/login` - User login
- `/dashboard` - Dashboard/home
- `/settings/business` - Business profile
- `/settings/users` - User management

### POS Pages
- `/pos` - Main POS interface
  - Menu browser (search, filter by category)
  - Order construction area
  - Payment processing
  - Receipt preview

### Inventory Pages
- `/inventory/menu-items` - Menu management
  - List menu items
  - Create/edit item
- `/inventory/stock` - Stock levels and adjustments

### Restaurant Pages
- `/restaurant/tables` - Table management
  - Table status board
- `/restaurant/orders` - Order management
  - Create order
  - View order details
  - Order history
- `/restaurant/kitchen` - Kitchen display
  - Real-time order list (preparing, ready)
  - Mark items as ready
  - Order completion

### Shared Components
- `Header` - Top navigation, user menu
- `Sidebar` - Main navigation with role-based items
- `Button` - Primary, secondary, danger variants
- `Modal` - Generic modal dialog
- `Form` - Form wrapper with validation
- `Table` - Data table component
- `Badge` - Status badges (Draft, Ready, Completed, etc.)
- `Card` - Content card container
- `Toast` - Notifications

### State Management (Pinia stores)
- `authStore` - Current user, authentication state
- `businessStore` - Current business, settings
- `posStore` - Current sale/transaction
- `restaurantStore` - Current order, tables
- `inventoryStore` - Menu items, stock levels

---

## 7. API Structure (Routes)

### Authentication Routes (`routes/api.php`)
```
POST   /auth/register          - Register new user
POST   /auth/login             - Login
POST   /auth/logout            - Logout
GET    /auth/user              - Current user
```

### Core Routes (`routes/core.php`)
```
GET    /business               - Get business details
PUT    /business               - Update business
GET    /business/settings      - Get settings
PUT    /business/settings      - Update settings

GET    /users                  - List users
POST   /users                  - Create user
PUT    /users/{id}             - Update user
DELETE /users/{id}             - Delete user
```

### POS Routes (`routes/modules/pos.php`)
```
POST   /sales                  - Create sale
GET    /sales                  - List sales
GET    /sales/{id}             - Get sale details
PUT    /sales/{id}             - Update sale
PUT    /sales/{id}/items       - Add/remove items
PUT    /sales/{id}/discount    - Apply discount
POST   /sales/{id}/complete    - Complete sale
GET    /sales/receipt/{id}     - Get receipt
```

### Inventory Routes (`routes/modules/inventory.php`)
```
GET    /menu-items             - List menu items
POST   /menu-items             - Create menu item
GET    /menu-items/{id}        - Get menu item
PUT    /menu-items/{id}        - Update menu item
DELETE /menu-items/{id}        - Delete menu item
GET    /menu-categories        - List categories

GET    /inventory/stock        - Stock levels
POST   /inventory/stock-in     - Receive stock
POST   /inventory/adjustments  - Adjust stock
```

### Restaurant Routes (`routes/verticals/restaurant.php`)
```
GET    /restaurant/menu        - Menu with modifiers
GET    /restaurant/tables      - List tables
POST   /restaurant/tables      - Create table
PUT    /restaurant/tables/{id} - Update table

POST   /restaurant/orders      - Create order
GET    /restaurant/orders      - List orders
GET    /restaurant/orders/{id} - Get order
PUT    /restaurant/orders/{id} - Update order
POST   /restaurant/orders/{id}/items - Add items
PUT    /restaurant/orders/{id}/items/{itemId} - Update item
DELETE /restaurant/orders/{id}/items/{itemId} - Remove item
POST   /restaurant/orders/{id}/confirm - Confirm order
PUT    /restaurant/orders/{id}/items/{itemId}/status - Update item status
```

---

## 8. Development Phases

### Phase 1: Foundation (Weeks 1-2)
**Goal**: Setup base infrastructure and Core module

- [x] Project setup with Laravel + Vue 3 + Tailwind
- [x] Database migrations scaffold
- [ ] User authentication (registration, login, logout)
- [ ] Business profile setup
- [ ] Role-based authorization
- [ ] User management UI
- [ ] Basic navigation/layout
- [ ] Auth routing and guards

**Deliverables**: 
- Working authentication system
- User login/register pages
- Basic dashboard with navigation
- User management interface

### Phase 2: POS Module (Weeks 3-4)
**Goal**: Build basic POS functionality

- [ ] Menu items CRUD
- [ ] Menu categories
- [ ] Stock level tracking
- [ ] POS sale creation
- [ ] Add/remove items from sale
- [ ] Discount application
- [ ] Payment processing (cash/card placeholder)
- [ ] Receipt generation/preview
- [ ] Sales transaction history

**Deliverables**:
- Working POS interface
- Menu management
- Sales history view
- Receipt printing capability

### Phase 3: Restaurant Features (Weeks 5-6)
**Goal**: Add restaurant-specific features

- [ ] Table management
- [ ] Order creation (dine-in/takeout)
- [ ] Modifier groups and modifiers
- [ ] Order workflow (draft → confirmed → preparing → ready → completed)
- [ ] Kitchen display system (simple)
- [ ] Mark items as ready
- [ ] Link orders to POS sales

**Deliverables**:
- Table status board
- Order management interface
- Kitchen display screen
- Order workflow in place

### Phase 4: Polish & Testing (Weeks 7-8)
**Goal**: Bug fixes, optimization, documentation

- [ ] End-to-end testing
- [ ] Performance optimization
- [ ] Error handling and validation
- [ ] API documentation
- [ ] User documentation
- [ ] Deployment setup
- [ ] Demo and feedback

**Deliverables**:
- Fully functional MVP
- API documentation
- Deployment guide
- Demo video

---

## 9. Tech Stack Confirmation

### Backend
- ✅ Laravel 11+
- ✅ PHP 8.3+
- ✅ MySQL (or PostgreSQL)
- ✅ Laravel Sanctum (API authentication)
- ✅ Eloquent ORM

### Frontend
- ✅ Vue 3 (Composition API)
- ✅ TypeScript
- ✅ Vite
- ✅ Tailwind CSS
- ✅ Axios (HTTP client)
- ✅ Pinia (State management)

### Development
- ✅ Composer (PHP dependencies)
- ✅ npm/pnpm (Node dependencies)
- ✅ PHPUnit (Backend tests)
- ✅ Vitest (Frontend tests)

---

## 10. Success Criteria

### Functional
- [ ] Users can register and log in
- [ ] Business owner can set up business profile
- [ ] Manager can create menu items and manage inventory
- [ ] Cashier can process POS sales
- [ ] Kitchen staff can view and update order status
- [ ] Reports show daily sales and inventory status

### Non-Functional
- [ ] API response time < 200ms (95th percentile)
- [ ] Frontend load time < 3 seconds (initial load)
- [ ] No console errors on main flows
- [ ] Mobile-responsive design (tablet minimum)
- [ ] Code coverage > 70% for critical paths

### User Experience
- [ ] Simple, intuitive POS interface
- [ ] No more than 3 clicks for main workflows
- [ ] Clear error messages
- [ ] Keyboard shortcuts for POS (optional for MVP)
- [ ] Real-time order updates

---

## 11. Post-MVP Roadmap

### Phase 5: Enhancement
- [ ] Customer profiles and loyalty
- [ ] Advanced reporting and analytics
- [ ] Stock forecasting
- [ ] Expense tracking module
- [ ] CRM features

### Phase 6: New Verticals
- [ ] Printing workflow
- [ ] Laundry workflow
- [ ] Retail workflow

### Phase 7: Advanced
- [ ] Multi-location support
- [ ] Actual payment gateway integration
- [ ] Kitchen display hardware integration
- [ ] Mobile app
- [ ] Microservices migration (if needed)

---

## 12. Key Assumptions

1. **Single location**: No multi-branch support in MVP
2. **Synchronous operations**: No complex async workflows
3. **Real-time**: Basic WebSocket/polling for kitchen display (can be enhanced)
4. **No hardware**: Thermal printers, barcode scanners are not integrated
5. **Basic security**: No advanced encryption or PCI compliance needed for MVP
6. **Simple analytics**: Basic sales/inventory reports only
7. **Single language**: English UI for MVP (i18n added later)

---

## 13. Risk Mitigation

| Risk | Mitigation |
|------|-----------|
| Scope creep | Clear phase gates, no "nice-to-haves" in phases 1-3 |
| Performance issues | Optimize queries early, cache menu items |
| Real-time complexity | Start simple, use polling instead of WebSockets |
| Testing delays | Write tests for critical paths only in MVP |
| Deployment issues | Use Docker for consistency |
| User confusion | Simple, guided workflows; minimal options |

---

## 14. Getting Started

1. **Setup environment**:
   ```bash
   composer install
   npm install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate
   ```

2. **Start development servers**:
   ```bash
   php artisan serve           # Backend on :8000
   npm run dev                 # Frontend on :5173
   ```

3. **Access application**:
   - Frontend: http://localhost:5173
   - API: http://localhost:8000/api

4. **Create first user**:
   - Register via signup form or use Laravel seeder

---

**Last Updated**: 2026-08-13  
**Next Review**: After Phase 1 completion
