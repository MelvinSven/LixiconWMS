# Inventory (Items, Units, Locations)

- **Status:** Implemented
- **Personas:** admin (write), staff (read + limited write), purchasing_admin (read)

## Purpose

The master catalog of `barang` (items) the WMS tracks, along with their `satuan` (units) and `lokasi_barang` (locations within a warehouse). Every inbound, outbound, transfer, and preorder references an item defined here.

## User stories

- As an **admin and project admin**, I want to register a new item with name, unit, category, location, and image.
- As an **admin**, I want to add new units and locations for items to reference.
- As any **user**, I want to view a list of items with their current global qty and per-warehouse qty.
- As **staff**, I want to see only items relevant to my warehouse (read-only across others is allowed for coordination).

## Acceptance criteria

1. `/items/register` creates a new `barang` row with optional image upload to `uploads/items/<hash>.<ext>`.
2. `/items` lists items with pagination (`/items/(:num)`) and shows `qty` from `barang`.
3. For `role='staff'`: `/items`, `/items/unit/:id`, `/items/availability/:param`, and `/items/search` all INNER JOIN `stok_gudang` scoped to the user's `id_gudang` — only items present in their warehouse are shown, and qty displayed is the warehouse-specific qty (not the global sum).
4. For `role='admin'` and `role='purchasing_admin'`: the full unfiltered catalog is shown with global qty.
5. `/items/warehouse/(:num)` shows stock filtered to one warehouse (joined with `stok_gudang`).
6. Deleting an item must also remove orphaned rows from `stok_gudang` (regression fixed in commit `15434bb`).
7. Units are managed at `/unit` (admin) and listed at `/units`.
8. Locations are managed at `/locations` with search at `/locations/search`.

## Routes

| Route | Controller@method | Who |
|---|---|---|
| `GET /items`, `/items/(:num)` | `Items::index` | authenticated |
| `GET /items/register`, `POST /items/store` | `Items` | admin |
| `GET /items/warehouse/(:num)[/(:num)]` | `Items::warehouse` | authenticated |
| `GET /item/...` | `Item` (detail/edit) | per-row permissions |
| `GET /unit`, `/units`, `/units/(:num)` | `Unit`, `Units` | admin for write |
| `GET /locations`, `/locations/(:num)`, `/locations/search[/(:num)]` | `Locations` | authenticated |

## Data touchpoints

- Reads/writes `barang`, `satuan`, `lokasi_barang`, `category` (currently disabled in sidebar).
- Reads `stok_gudang` for per-warehouse views.
- Writes `uploads/items/` for images.
- **Stock counters:** does NOT directly mutate `barang.qty` or `stok_gudang.qty` — those are touched by inbound/outbound/transfer features.

## Out of scope

- Barcode scanning.
- Bulk item import (CSV).
- Reactivating the `category` module (currently commented out in `_sidebar.php`).

## Open questions

- `category` table exists and the controllers are wired, but sidebar is commented out. Is this slated for removal or re-activation?
