# Current task

<!-- Single running-task log. Keep one active task here at a time. When finished, clear this section and start the next task, or archive completed notes under `## Done` below. -->
For the current task, i want to allow Admin (Main Admin not Project Admin) to delete Purchase Requests.

---

## Done

### Layout theme alignment (2026-05-25)
- Created `assets/css/theme.css` — overrides admin template skin6 defaults
- Linked after `style.min.css` in `dashboard.php`
- Navbar: white bg, subtle border-bottom, clean role badge with display names
- Sidebar: blue active state (replaces purple gradient), muted section caps, light dividers, blue hover
- Breadcrumb header: white bg, border-bottom, dark title, muted path text

## Active

**Task:** Restrict Barang Masuk / Barang Keluar to admin only; remove item edit for Purchasing Admin.

**Feature:** [stock-inbound.md](../features/stock-inbound.md), [stock-outbound.md](../features/stock-outbound.md), [inventory.md](../features/inventory.md)

**Goal:**
- Project Admin (`staff`) and Purchasing Admin (`purchasing_admin`) have **no access** to add stock via Barang Masuk or decrease stock via Barang Keluar — admin only.
- Project Admin keeps the ability to correct stock on **his own warehouse** (Update Stok → `warehouse/update_stock`).
- Purchasing Admin is **view-only** for items (no register/edit/stock change).

**Checklist:**
- [x] `Cartin::__construct` — reject non-admin (whole barang masuk controller).
- [x] `Cartout::__construct` — reject non-admin (whole barang keluar controller).
- [x] `Items::store` / `register` / `update` — reject `purchasing_admin`.
- [x] `Warehouse::update_stock` — reject `purchasing_admin` (id_gudang check alone bypassable when id_gudang null).
- [x] `warehouses/detail.php` — Tambah Barang Masuk → admin only; Update Stok → `can_modify && role != purchasing_admin`.
- [x] `items/warehouse.php` — Masuk / Keluar buttons + modals → admin only.
- [x] Specs updated (inbound/outbound personas → admin only; inventory access summary).

**Notes / decisions:**
- Sidebar Barang Masuk / Keluar menus were already fully commented out; admin reaches the flow via warehouse detail + items/warehouse buttons.
- `Items::store`/`register` kept open to `staff` (Project Admin still registers items) — only `purchasing_admin` blocked.
- `php -l` clean on all six edited PHP files. Server-side guards are the enforcement; view gates are cosmetic.

**Blockers:**
- none

---

### Follow-up: remove old Transfer (Pemindahan Barang) feature

Superseded by Permintaan Barang (internal preorder).

- [x] Deleted `controllers/Transfer.php`, `models/Transfer_model.php`, `views/pages/transfers/`.
- [x] Removed `/transfer*` routes and the (commented) sidebar entry.
- [x] Removed dashboard "Riwayat Pemindahan" panel — `Home::index` (`transferModel` load + `dashboard_transfers`) and `home/index.php` table + JS init.
- [x] Marked `specs/features/transfers.md` Deprecated/removed; updated CLAUDE.md feature index + §5 notes.
- [x] **DB tables dropped** — `transfer_gudang` / `transfer_gudang_detail` + `transfer_barang_gudang` trigger removed from base schema (`database_wms.sql`); `database/migration_drop_transfer.sql` drops them on existing DBs. Dead transfer guards/cleanup removed from `Warehouse::delete`.
- Left `login.php` marketing copy ("transfer gudang") and Preorder.php code comments (word "transfer") untouched — not the feature.

---

## Conventions

- `[ ]` todo · `[~]` in progress · `[x]` done · `[!]` blocked.
- Update this file as you work — it is the source of truth for what is currently underway.
- On completion: either clear `## Active` for the next task, or move its contents into `## Done` with today's date.
- When starting new work, first confirm the feature spec at `specs/features/<feature>.md` is up to date. If the work changes behavior, update the spec before writing code.

---

## Done

<!-- Archive finished tasks here with date headers, newest first. Trim periodically. -->
