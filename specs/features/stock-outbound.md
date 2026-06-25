# Stock Outbound (Barang Keluar)

- **Status:** Implemented
- **Personas:** admin only (Project Admin / `staff` and Purchasing Admin have **no access** to barang keluar)

## Purpose

Record goods leaving a warehouse. The flow mirrors inbound: cart (`keranjang_keluar`) → commit as `barang_keluar` + `barang_keluar_detail`. A BEFORE-INSERT trigger decrements `barang.qty`; PHP decrements `stok_gudang.qty`.

> **Access:** Decreasing stock through Barang Keluar is restricted to the super-admin (`role = 'admin'`). Project Admin (`staff`) adjusts their own warehouse stock via the **Update Stok** flow (`warehouse/update_stock`, see `inventory.md`). Purchasing Admin has view-only access to items.

## User stories

- As **admin**, I want to add items to an outbound cart with quantity and optional proof photo + keterangan, then commit so warehouse stock decreases.
- As **admin**, I want to review the list of past outbound records (`Catatan Keluar`).

## Acceptance criteria

1. `/cartout` manages the working cart in `keranjang_keluar`; the `Cartout` controller rejects any non-admin (`role != 'admin'`) in its constructor and redirects to `items`.
2. Committing creates one `barang_keluar` + N `barang_keluar_detail` rows.
3. The `kurangi_barang` trigger fires BEFORE INSERT on `barang_keluar_detail` → decrements `barang.qty`, and should reject if global qty would go negative.
4. PHP code decrements `stok_gudang(id_gudang, id_barang)` in the same transaction; reject if per-warehouse qty would go negative.
5. Optional `bukti_foto` (`migration_add_bukti_foto_barang_keluar.sql`) and `keterangan` (`migration_add_keterangan_barang_keluar.sql`) are captured.
6. `/outputs` (Catatan Keluar) lists historical outbound records.

## Routes

| Route | Controller@method | Who |
|---|---|---|
| `GET /cartout` (+ `add`, `update`, `delete`, `drop`, `checkout`) | `Cartout` | **admin only** |
| `GET /outputs`, `/outputs/(:num)` | `Outputs::index` | authenticated |

Entry point (UI): the **Keluar** button on `items/warehouse.php` is gated to `role == 'admin'`.

## Data touchpoints

- Writes: `keranjang_keluar`, `barang_keluar`, `barang_keluar_detail`, `stok_gudang`.
- Reads: `barang`, `gudang`, `satuan`.
- Writes files to `uploads/` for proof photos.
- **Stock counters:** `barang.qty` via trigger, `stok_gudang.qty` via PHP.

## Out of scope

- Outbound tied to a sales invoice (no sales module).
- Reservation / hold (quantity is decremented immediately on commit).

## Open questions

- Does the trigger + PHP decrement stay consistent if one fails mid-transaction? Confirm transaction wrapping in `Cartout_model`.
