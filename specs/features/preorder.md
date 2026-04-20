# Internal Preorder (Permintaan Barang)

- **Status:** In Progress
- **Personas:** requesting project admin (request), target project admin (approve + ship + verify)

## Purpose

An internal pull workflow: **Project admin** at a warehouse request items they need from another warehouse. the target warehouse's **Project Admin** approves, issues a `surat_jalan` (delivery note), ships, then the requesting project admin verifies receipt.

## User stories

- As requesting **project admin**, I want to create a preorder listing items + quantities + target source warehouse.
- As target **project admin**, I want to approve or reject the preorder (with reason).
- As target **project admin**, I want to generate a surat jalan (delivery note), print it, and mark as shipped.
- As requesting **project admin**, I want to verify received quantities against the preorder and mark discrepancies.

## Acceptance criteria

1. `/preorder/create` is staff-only; form captures source warehouse + items + qty.
2. Status lifecycle: `pending` → `approved` / `rejected` → `shipped` → `verified`.
3. `/preorder/approve/(:num)` and `/preorder/reject/(:num)` are admin-only.
4. Surat jalan flow: `/preorder/surat_jalan/(:num)` (form) → `/preorder/store_surat_jalan/(:num)` (commit) → `/preorder/print_surat_jalan/(:num)` (PDF/print view).
5. `/preorder/kirim/(:num)` marks as shipped and decrements `stok_gudang` at target/source warehouse.
6. `/preorder/verifikasi/(:num)` captures `qty_diterima` per line (migration `migration_add_qty_diterima.sql` + `migration_verifikasi_detail.sql`); partial receipts flagged.
7. On verification, destination warehouse's `stok_gudang` is incremented;
8. `status_pengiriman` + `nama_kurir` are optional fields (migrations `migration_add_status_pengiriman.sql`, `migration_add_nama_kurir.sql`).

## Routes

| Route | Controller@method | Who |
|---|---|---|
| `GET /preorder` | `Preorder::index` | authenticated |
| `GET /preorder/create`, `POST /preorder/store` | `Preorder` | requesting project admin |
| `GET /preorder/detail/(:num)` | `Preorder::detail` | authenticated |
| `POST /preorder/approve/(:num)`, `/reject/(:num)` | `Preorder` | target/source project admin |
| `GET|POST /preorder/surat_jalan/(:num)`, `/store_surat_jalan/(:num)`, `/print_surat_jalan/(:num)` | `Preorder` | target/source project admin |
| `POST /preorder/kirim/(:num)` | `Preorder::kirim` | target/source project admin |
| `GET|POST /preorder/verifikasi/(:num)`, `/store_verifikasi/(:num)`, `/print_verifikasi/(:num)` | `Preorder` | requesting project admin |
| `POST /preorder/delete/(:num)` | `Preorder::delete` | admin or requester (pre-approval) |
| `GET /preorder/getStokByGudang/(:num)` | `Preorder::getStokByGudang` | authenticated (AJAX) |

## Data touchpoints

- Writes: `permintaan_barang`, `permintaan_barang_detail`, `surat_jalan`, `surat_jalan_detail`, `stok_gudang`.
- Reads: `barang`, `gudang`, `user`, `satuan`.
- **Stock counters:** `stok_gudang` only (source decrement on ship, destination increment on verify).

## Out of scope

- Automatic reorder based on low-stock thresholds.
- Approval chaining (single-step approve).

## Open questions

- Partial receipt: what happens to the discrepancy? Is the missing qty auto-returned to source `stok_gudang`, or held as "lost"?
