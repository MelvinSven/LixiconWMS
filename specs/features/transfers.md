# Inter-Warehouse Transfer (Pemindahan Barang)

- **Status:** Deprecated — **removed** (2026-06-25)
- **Personas:** _(none — feature removed)_

> **Removed.** The standalone Transfer (Pemindahan Barang) feature was deleted. Inter-warehouse movement is now handled by **Permintaan Barang (internal preorder)** — see [preorder.md](preorder.md), which adds an approve / surat-jalan / verify workflow the old immediate transfer lacked.
>
> Deleted in this change: `controllers/Transfer.php`, `models/Transfer_model.php`, `views/pages/transfers/`, the `/transfer*` routes, the sidebar entry, and the dashboard "Riwayat Pemindahan" panel (`Home` + `home/index.php`).
>
> **DB dropped:** tables `transfer_gudang` / `transfer_gudang_detail` and the `transfer_barang_gudang` trigger were removed from the base schema (`database/database_wms.sql`) and are dropped on existing databases via `database/migration_drop_transfer.sql`. The now-dead transfer guards/cleanup were removed from `Warehouse::delete`.
>
> The original spec is retained below as a historical record.

## Purpose

Move stock from one warehouse to another without affecting the global `barang.qty` (since total on-hand is unchanged). Only `stok_gudang` rows are rebalanced.

## User stories

- As **admin** or **staff**, I want to create a transfer by selecting source warehouse, destination warehouse, items, and quantities.
- As a user, I want to see the history of all transfers with optional proof photo.
- As a user, I want a transfer detail view with source/destination + line items.

## Acceptance criteria

1. `/transfer/create` renders the new-transfer form; staff see only their own warehouse as the source.
2. `/transfer/getStokByGudang/(:num)` returns JSON of available `stok_gudang` rows for dropdown population.
3. Committing creates one `transfer_gudang` + N `transfer_gudang_detail` rows.
4. PHP code decrements `stok_gudang` at the source and increments at the destination in a single transaction.
5. `barang.qty` is NOT modified by transfers (net zero).
6. Optional `bukti_foto` upload (migration `migration_add_bukti_foto_transfer.sql`).
7. `/transfer` lists all transfers with pagination; `/transfer/detail/(:num)` shows one.

## Routes

| Route | Controller@method | Who |
|---|---|---|
| `GET /transfer` | `Transfer::index` | authenticated |
| `GET /transfer/create`, `POST /transfer/store` | `Transfer` | admin, staff |
| `GET /transfer/detail/(:num)` | `Transfer::detail` | authenticated |
| `GET /transfer/getStokByGudang/(:num)` | `Transfer::getStokByGudang` | authenticated (AJAX) |

## Data touchpoints

- Writes: `transfer_gudang`, `transfer_gudang_detail`, `stok_gudang` (two rows per line item).
- Reads: `barang`, `gudang`, `stok_gudang`.
- Writes files to `uploads/` for proof photos.
- **Stock counters:** `stok_gudang` only — `barang.qty` unchanged.

## Out of scope

- Approval workflow (transfers are immediate, not draft/approve/ship).
- In-transit status (stock deducts from source on commit, credits to destination instantly).

## Open questions

- Should transfers support a draft / in-transit status so stock can be held rather than instantly credited?
