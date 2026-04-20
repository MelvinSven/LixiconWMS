# Stock Inbound (Barang Masuk)

- **Status:** Implemented
- **Personas:** admin, staff (scoped to their warehouse)

## Purpose

Record goods arriving at a warehouse. The flow: user builds a cart (`keranjang_masuk`), then commits it as a `barang_masuk` header with `barang_masuk_detail` lines. A DB trigger increments `barang.qty`; PHP code increments `stok_gudang.qty`.

## User stories

- As **staff**, I want to add items to an inbound cart and record quantity + optional proof photo, then commit the batch so warehouse stock increases.
- As **staff**, I want to review the list of past inbound records (`Catatan Masuk`).

## Acceptance criteria

1. `/cartin` manages the working cart in `keranjang_masuk`.
2. Committing the cart creates one `barang_masuk` row + N `barang_masuk_detail` rows.
3. The `tambah_barang` trigger fires AFTER INSERT on `barang_masuk_detail` → increments `barang.qty`.
4. PHP code increments `stok_gudang(id_gudang, id_barang)` for the user's warehouse in the same transaction.
5. Optional `bukti_foto` upload attaches a proof photo (migration `migration_add_bukti_foto_barang_masuk.sql`).
6. Supplier linkage is optional (migration `migration_add_supplier.sql`).
7. `/inputs` (Catatan Masuk) lists all historical inbound records, scoped by warehouse for non-admin.

## Routes

| Route | Controller@method | Who |
|---|---|---|
| `GET /cartin` | `Cartin` | staff, admin |
| `GET /inputs`, `/inputs/(:num)` | `Inputs::index` | authenticated |

## Data touchpoints

- Writes: `keranjang_masuk`, `barang_masuk`, `barang_masuk_detail`, `stok_gudang`.
- Reads: `barang`, `gudang`, `supplier`, `satuan`.
- Writes files to `uploads/` for proof photos.
- **Stock counters:** `barang.qty` via trigger, `stok_gudang.qty` via PHP.

## Out of scope

- Inbound tied to a Purchase Order (that flow lives in `purchaserequest.md` Goods Receipt).
- Batch/serial number tracking.

## Open questions

- Does the "simple" cart inbound skip `stok_gudang` increment if the user is admin (no `id_gudang`)? Confirm behavior when committing from an admin session.
