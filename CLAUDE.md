# CLAUDE.md — Master Spec & Agent Instructions

Authoritative guide for Claude Code (and any other agent) working in this repository. This file is the **master spec**: it defines the system architecture, models, conventions, and the SDD (Spec-Driven Development) workflow that feature specs and tasks follow.

For feature-level detail, see `specs/features/`. For the currently active work item, see `specs/tasks/current-task.md`.

---

## 1. Stack

- **PHP CodeIgniter 3** (MVC framework; see `system/` and `application/`).
- **MySQL** (schema in `database/database_wms.sql` + incremental `migration_*.sql` files).
- **Bootstrap 4 + jQuery + SweetAlert** for the UI (pre-compiled, committed under `assets/`).
- **No build step, no linter, no test runner, no CI** is configured. Assets are served as-is.

## 2. Local dev setup

1. Serve the project root with PHP's built-in server:
   ```
   php -S localhost:8000
   ```
2. Import `database/database_wms.sql` into MySQL, then apply any `migration_*.sql` files newer than your schema.
3. Confirm `application/config/config.php` has `$config['base_url'] = 'http://localhost:8000/';`.
4. Confirm `application/config/database.php` points to your local DB (default: `easy_wms_test`). Production credentials for Hostinger are committed but commented out — never uncomment them in a PR.

---

## 3. Architecture

### 3.1 MVC conventions

- **`application/core/MY_Controller.php`** — base controller. Its `__construct()` auto-loads the matching model (e.g. `Items` controller → `Items_model`, bound to `$this->items`). The `view($data, $isLogin = false)` method loads either `pages/auth/login` or the main `layouts/dashboard` wrapper.
- **`application/core/MY_Model.php`** — base model. Provides chainable query-builder helpers (`select`, `where`, `like`, `join`, `paginate`, …) plus CRUD (`create`, `update`, `delete`), and `makePagination()`. Set `$this->table` in the subclass; if omitted, the table name is derived from the class name.
- Controllers that need a second model load it manually: `$this->load->model('Foo_model', 'foo')`.
- Every authenticated controller's `__construct()` must guard:
  ```php
  if (!$this->session->userdata('is_login')) {
      $this->session->set_flashdata('warning', 'Anda belum login');
      redirect(base_url('login'));
      return;
  }
  ```

### 3.2 Views & layouts

- **Layout wrapper:** `application/views/layouts/dashboard.php` renders navbar + sidebar then `$this->load->view($page)` for page content.
- **Page views** live under `application/views/pages/<feature>/<action>.php` (`index.php`, `form.php`, `detail.php`, …).
- **Partials** live under `application/views/layouts/` (e.g. `_sidebar.php`, `_navbar.php`).
- Every controller must pass these keys in `$data`:
  | Key | Purpose |
  |---|---|
  | `page` | relative view path, e.g. `'pages/items/index'` |
  | `title` | browser tab title |
  | `breadcrumb_title` | page header |
  | `breadcrumb_path` | breadcrumb trail, e.g. `'Barang / Register'` |

### 3.3 Routing

- All named URLs are defined explicitly in `application/config/routes.php`. Do **not** rely on CodeIgniter's default `controller/method/id` auto-routing for new clean URLs.
- Always add an explicit route when introducing a new controller action that needs a clean URL.

---

## 4. Session & roles

### 4.1 Session keys

After login, these are available via `$this->session->userdata(...)`:

| Key | Contents |
|---|---|
| `is_login` | bool |
| `id_user` | int |
| `nama` | string |
| `email` | string |
| `role` | `'admin'` / `'staff'` / `'purchasing_admin'` |
| `id_gudang` | int, or `null` for admin (all warehouses) |

### 4.2 Role model

| DB `role` value | Persona in PRD | Access |
|---|---|---|
| `admin` | Super-admin | full access across all warehouses; only role that can register new users |
| `staff` | **Project Admin** | warehouse-scoped; creates Purchase Requests and Preorders |
| `purchasing_admin` | **Purchasing Admin** | manages Purchase Requests / Orders / Suppliers |

> Mapping gotcha: `admin` ≠ "admin persona in PRD". When the PRD says "Project Admin", the DB role is `staff`.

### 4.3 Helpers for permission checks

Defined in `application/helpers/easy_wms_helper.php`:

- `getUserGudangId()` — returns the current user's warehouse ID, or `null` for admin.
- `isWarehouseRestricted()` — `true` when the query should be scoped to a single warehouse.

Use these instead of re-querying `user.id_gudang` yourself.

---

## 5. Data model

### 5.1 Dual stock counters

There are **two** stock tables and both must be kept consistent:

- **`barang.qty`** — global aggregate, updated by **database triggers**:
  - `tambah_barang` — fires AFTER INSERT on `barang_masuk_detail`
  - `kurangi_barang` — fires BEFORE INSERT on `barang_keluar_detail`
- **`stok_gudang(id_gudang, id_barang, qty)`** — per-warehouse stock, updated **in PHP code** (not by triggers). Used by transfers, preorders, and anything warehouse-scoped.

When adding a new inbound/outbound flow, decide which table(s) to update and how.

### 5.2 Core tables

Defined in `database/database_wms.sql`:

- Catalog: `barang`, `satuan`, `category`, `lokasi_barang`, `supplier`, `gudang`
- Stock: `stok_gudang`, `v_stok_gudang`, `v_ringkasan_gudang`
- Inbound: `keranjang_masuk`, `barang_masuk`, `barang_masuk_detail`
- Outbound: `keranjang_keluar`, `barang_keluar`, `barang_keluar_detail`
- Transfers: `transfer_gudang`, `transfer_gudang_detail`
- Internal preorder: `permintaan_barang`, `permintaan_barang_detail`, `surat_jalan`, `surat_jalan_detail`
- Users: `user`

Added via migrations:

- Purchase Request / Order: `purchase_request`, `purchase_request_detail`, `purchase_order`, `purchase_order_detail` (see `database/migration_purchase_request.sql`).

### 5.3 Helper DB functions

High-traffic helpers in `easy_wms_helper.php`:

- `getWarehouses()`, `getWarehouseName($id)`, `getWarehouseSummary($id)`
- `getStokGudang($id_gudang, $id_barang)`, `getStokBarangAllGudang($id_barang)`, `getTotalStokAllGudang()`
- `getSuppliers()`, `getSupplierName($id)`
- `getUnits()`, `getUnitName($id)`
- `getLocations()`, `getLocationName($id)`
- `hashEncrypt($input)` / `hashEncryptVerify($input, $hash)` — wrap `password_hash` / `password_verify`

---

## 6. Conventions

### 6.1 Flash messages

Keys: `success`, `error`, `warning`. They render in the dashboard layout and are **manually cleared** at the end of `layouts/dashboard.php` via `$this->session->unset_userdata(...)`. This is intentional — it avoids double-display on ngrok / reverse-proxy setups. Don't switch to CI's built-in flashdata cycle without understanding this.

### 6.2 File uploads

- Item images: `uploads/items/<hash>.<ext>`
- Transaction proof photos (bukti foto): `uploads/` (barang_masuk, barang_keluar, transfer variants)
- Purchase Order PDFs: stored under `uploads/` via the purchase request feature.

Always write through CodeIgniter's `Upload` library so MIME validation and size limits are enforced.

### 6.3 Sidebar & role-gated menu

`application/views/layouts/_sidebar.php` uses `<?php if ($this->session->userdata('role') == 'admin'): ?>` blocks to hide admin-only entries. When a new feature is role-restricted, gate the sidebar entry too — don't only rely on controller-level checks.

### 6.4 Pagination

Use `MY_Model::paginate($page, $perPage)` and `makePagination()`. Route pattern: `controller/(:num)` → `controller/index/$1`.

### 6.5 Form validation

Controllers load `$this->load->library('form_validation')` and use `$this->form_validation->set_rules(...)`. Validation failures should re-render the form with `validation_errors()` plus a `warning` flash message.

---

## 7. Key files

| Path | Purpose |
|---|---|
| `application/config/config.php` | `base_url`, CSRF, session settings |
| `application/config/database.php` | DB credentials (local vs. prod — prod is commented out) |
| `application/config/routes.php` | All custom URI routes |
| `application/helpers/easy_wms_helper.php` | Global helpers (`getUserGudangId`, `hashEncrypt`, stock lookups, …) |
| `application/core/MY_Controller.php` | Base controller — auto model-loading + `view()` |
| `application/core/MY_Model.php` | Base model — chainable CRUD + pagination |
| `application/views/layouts/dashboard.php` | Main layout wrapper |
| `application/views/layouts/_sidebar.php` | Role-gated sidebar |
| `database/database_wms.sql` | Full schema |
| `database/migration_*.sql` | Incremental schema changes |
| `uploads/` | Uploaded item images + transaction proof photos |

---

## 8. SDD (Spec-Driven Development) workflow

This project uses a **flat**, minimal Spec-Driven Development layout:

```
CLAUDE.md                       ← this file — master spec & agent instructions
specs/
  features/
    <feature>.md                ← one markdown file per feature
  tasks/
    current-task.md             ← the single active work-item log
```

### 8.1 When adding a new feature

1. Create `specs/features/<feature>.md` describing the feature (user stories, acceptance criteria, data touchpoints, routes, status).
2. Update the **Feature index** in §9 below.
3. If this file (`CLAUDE.md`) needs new conventions or tables to support the feature, update CLAUDE.md **before** writing code.
4. Open `specs/tasks/current-task.md`, record the active task (goal, subtasks, status), and work off of it.
5. When merging, update the feature's spec Status from `Planned` → `In progress` → `Implemented`.

### 8.2 When changing an existing feature

- Update the feature's `specs/features/<feature>.md` alongside the code change (at minimum the Acceptance criteria and Status line).
- If architecture shifts (new base-class behavior, new stock-counter rules, new role), update CLAUDE.md too.

### 8.3 Feature-spec structure

Every `specs/features/<feature>.md` should at minimum have:

- **Status** — `Planned` / `In progress` / `Implemented` / `Deprecated`
- **Personas** — which DB roles interact with it
- **Routes** — URIs + controller methods + who can access
- **Data touchpoints** — tables + stock-counter impact
- **Acceptance criteria** — numbered, testable statements

### 8.4 Running-task log

`specs/tasks/current-task.md` is the **one** running-task file. It tracks the item you're actively working on: goal, checklist, notes, blockers. When a task is done, clear the file (or archive its content under a `## Done` section at the bottom if useful) and write the next one.

---

## 9. Feature index

Pointers to per-feature specs under `specs/features/`:

| Feature | Spec | Status |
|---|---|---|
| Authentication (login / logout / staff registration) | [authentication.md](specs/features/authentication.md) | Implemented |
| Dashboard / home | [dashboard.md](specs/features/dashboard.md) | Implemented |
| User (staff) management | [user-management.md](specs/features/user-management.md) | Implemented |
| Item (barang) management + units + locations | [inventory.md](specs/features/inventory.md) | Implemented |
| Warehouse (gudang) management | [warehouses.md](specs/features/warehouses.md) | Implemented |
| Supplier directory | [suppliers.md](specs/features/suppliers.md) | Implemented |
| Stock inbound (barang masuk) | [stock-inbound.md](specs/features/stock-inbound.md) | Implemented |
| Stock outbound (barang keluar) | [stock-outbound.md](specs/features/stock-outbound.md) | Implemented |
| Inter-warehouse transfer | [transfers.md](specs/features/transfers.md) | Implemented |
| Internal preorder (permintaan barang) | [preorder.md](specs/features/preorder.md) | Implemented |
| Purchase Request → PO → Goods Receipt | [purchaserequest.md](specs/features/purchaserequest.md) | In progress |

PRD source for the purchasing flow: `PRD Purchasing Request.md`.
