# Stock Outbound (Barang Keluar)

- **Status:** Implemented
- **Personas:** admin, staff (scoped to their warehouse)

## Purpose

Record goods leaving a warehouse. The flow mirrors inbound: cart (`keranjang_keluar`) → commit as `barang_keluar` + `barang_keluar_detail`. A BEFORE-INSERT trigger decrements `barang.qty`; PHP decrements `stok_gudang.qty`.

## User stories

- As **staff**, I want to add items to an outbound cart with quantity and optional proof photo + keterangan, then commit so warehouse stock decreases.
- As **staff**, I want to review the list of past outbound records (`Catatan Keluar`).

## Acceptance criteria

1. `/cartout` manages the working cart in `keranjang_keluar`; warehouse-scope enforced (regression fixed in commit `fcad212`).
2. Committing creates one `barang_keluar` + N `barang_keluar_detail` rows.
3. The `kurangi_barang` trigger fires BEFORE INSERT on `barang_keluar_detail` → decrements `barang.qty`, and should reject if global qty would go negative.
4. PHP code decrements `stok_gudang(id_gudang, id_barang)` in the same transaction; reject if per-warehouse qty would go negative.
5. Optional `bukti_foto` (`migration_add_bukti_foto_barang_keluar.sql`) and `keterangan` (`migration_add_keterangan_barang_keluar.sql`) are captured.
6. `/outputs` (Catatan Keluar) lists historical outbound records.

## Routes

| Route | Controller@method | Who |
|---|---|---|
| `GET /cartout` | `Cartout` | staff, admin |
| `GET /outputs`, `/outputs/(:num)` | `Outputs::index` | authenticated |

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
