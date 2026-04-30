# Purchase Request → Purchase Order → Goods Receipt

- **Status:** In progress
- **Personas:** staff (Project Admin — creates PR, verifies goods), purchasing_admin (Purchasing Admin — accepts PR, creates PO, tracks delivery), admin (Super-admin — can delete any PR regardless of status)
- **PRD:** [`PRD Purchasing Request.md`](../../PRD%20Purchasing%20Request.md)

## Purpose

External procurement workflow: when a Project Admin needs items the warehouse doesn't have, they submit a **Purchase Request** (PR). The Purchasing Admin reviews and, if accepted, creates a **Purchase Order** (PO) to a supplier. When goods arrive, the Project Admin performs a **Goods Receipt** (verify + inspect), which adds inventory on full match or flags discrepancies for follow-up.

## User stories

- As **Project Admin** (`role=staff`), I want to create a PR with item(s), quantity, unit, and notes, and optionally attach a photo of the physical Purchase Request (JPG/PNG).
- As **any authenticated user**, I want to see the uploaded PR photo on the PR Detail page.
- As **Project Admin**, I want to add **manual items** (items not yet in the `barang` catalog) to a PR by typing Nama Barang, picking Satuan, and entering Qty + Keterangan.
- As **Purchasing Admin** (`role=purchasing_admin`), I want to accept or decline a PR with a reason.
- As **Project Admin**, I want to revise and resubmit a declined PR.
- As **Admin** (`role=admin`), I want to delete any PR regardless of its status, so I can clean up erroneous or obsolete requests.
- As **Purchasing Admin**, I want to create a PO from an accepted PR, pick a supplier, set pricing, upload a PDF of the PO, and print it.
- As **Purchasing Admin**, I want to update PO status as the supplier acknowledges and ships.
- As **Project Admin**, I want to open a Goods Receipt tied to a PR/PO, record received qty per item, inspect for defects, and mark `Full Match` or `Partial / With Discrepancies`.
- As **Project Admin**, I want to upload the official **Surat Jalan** (delivery document PDF) while verifying items, so there is a legal record attached to the goods receipt.
- On `Full Match`, items should be added to the warehouse inventory automatically.
- On `Partial / With Discrepancies`, the Purchasing Admin should be notified for supplier follow-up.

## Acceptance criteria

See PRD for the authoritative list. Key points:

1. PR status lifecycle: `menunggu` → accept → `disetujui` / reject → `ditolak`. After Project Admin verifies goods: `belum_selesai` (partial) or `selesai` (all matched).
13. Per-item delivery state (`status_pengiriman`): a 3-step progress bar (Diproses → Dikirim → Sampai) is shown below the Daftar Barang table when PR is `disetujui`, `belum_selesai`, or `selesai`. Purchasing Admin and Admin can set each item to any state via buttons in the progress bar. The State Progress Bar is hidden for `menunggu`/`ditolak`. Default state is `diproses`.
2. Admin can delete a PR in **any** status; staff can only delete PRs in `menunggu` or `ditolak`. The delete button appears in the Aksi column of the PR list next to the Detail button.
3. PR is tagged with the requesting warehouse and Project Admin name (PR-02).
4. PO status lifecycle: `Pending` → `Sent to Supplier` → `Shipped` → `Delivered` (PO-06).
5. System auto-generates PO number (PO-04) and exports PO as PDF (PO-05).
6. PO links back to originating PR (PO-07, GR-08) for traceability.
7. Goods Receipt auto-populates expected items from the PR/PO (GR-02) and captures per-line `qty_diterima` + defect notes (GR-03).
8. On `Full Match` verification, `barang_masuk` + `barang_masuk_detail` rows are inserted → triggers `tambah_barang` → `barang.qty` +=; PHP also updates `stok_gudang` for the destination warehouse (GR-05).
9. On `Partial / With Discrepancies`, the PO is flagged and the Purchasing Admin is notified (GR-06).
10. Per-line item verification is captured via `migration_pr_item_verification.sql`.
12. During verifikasi, Project Admin may optionally upload a **Surat Jalan PDF** (max 10 MB). Each upload appends a new entry to `surat_jalan_pr` — previous uploads are never overwritten. The file is stored in `uploads/surat_jalan/` using the original filename from the uploader (CI appends a counter on collision). The PR detail page and the verifikasi page both show the full list of uploaded Surat Jalan with upload date and download link.
11. Manual items (`purchase_request_detail.id_barang IS NULL`, name in `nama_barang_manual`, unit in `id_satuan_manual`) are added via `migration_pr_manual_item.sql`. On verifikasi with `qty_diterima > 0`, a manual item is **promoted** into the `barang` catalog (new row inserted, detail row repointed via `id_barang` and manual columns cleared) and the accepted qty is added to `stok_gudang` for the PR's warehouse — so the new item appears in Daftar Barang and warehouse stock. Manual items with `qty_diterima = 0` remain unpromoted until re-verifikasi supplies a positive qty.

## Routes (currently wired)

| Route | Controller@method | Who |
|---|---|---|
| `GET /purchaserequest`, `POST /purchaserequest/store` | `Purchaserequest` | staff, purchasing_admin, admin |
| `GET /purchaserequest/create` | `Purchaserequest::create` | staff |
| `GET /purchaserequest/detail/(:num)` | `Purchaserequest::detail` | authenticated |
| `POST /purchaserequest/accept/(:num)` | `Purchaserequest::accept` | purchasing_admin |
| `POST /purchaserequest/reject/(:num)` | `Purchaserequest::reject` | purchasing_admin |
| `GET|POST /purchaserequest/verifikasi/(:num)` | `Purchaserequest::verifikasi` | staff (requester) |
| `POST /purchaserequest/store_verifikasi/(:num)` | `Purchaserequest::store_verifikasi` | staff (requester) |
| `POST /purchaserequest/update_qty/(:num)` | `Purchaserequest::update_qty` | staff or purchasing_admin |
| `POST /purchaserequest/delete/(:num)` | `Purchaserequest::delete` | staff (status `menunggu`/`ditolak` only) or admin (any status) |
| `POST /purchaserequest/update_status_pengiriman/(:num)` | `Purchaserequest::update_status_pengiriman` | purchasing_admin, admin |

## Data touchpoints

- `purchase_request.foto_pr` (VARCHAR 255, nullable) — path to the uploaded PR image; added by `migration_pr_foto.sql`. Stored under `uploads/purchaserequests/`.
- Tables created by `database/migration_purchase_request.sql`:
  - `purchase_request`, `purchase_request_detail`
  - `purchase_order`, `purchase_order_detail`
- Also touched by `migration_pr_item_verification.sql` and `migration_pr_surat_jalan.sql`.
- `surat_jalan_pr(id, id_pr, nama_file, file_path, uploaded_at)` — one row per uploaded Surat Jalan; created by `migration_pr_surat_jalan.sql`.
- `migration_pr_manual_item.sql` makes `purchase_request_detail.id_barang` nullable and adds `nama_barang_manual` + `id_satuan_manual` for items input manually.
- On Goods Receipt full-match: writes `barang_masuk` + `barang_masuk_detail` (reuses inbound flow) + updates `stok_gudang`.
- **Stock counters:** only mutated at Goods Receipt verification (not at PR or PO creation).
- `purchase_request_detail.status_pengiriman` ENUM(`diproses`,`dikirim`,`sampai`) DEFAULT `diproses` — added by `migration_pr_status_pengiriman.sql`, migrated to 3-step by `migration_delivery_state.sql`.

## Out of scope (for now)

- Supplier performance metrics (PRD SUP-05, P2).
- In-app notifications to Project Admin / Purchasing Admin (PR-06, GR-06) — may be email or dashboard banner later.
- Automatic PR revision workflow (PR-07, P1).

## Open questions

- PO creation UI: is there a dedicated `/purchaseorder` controller planned, or will PO fields live inside the Purchase Request detail page?
- PDF export (PO-05): which library (DomPDF, TCPDF, mPDF) — and is it already in `vendor/`?
- How are notifications delivered? No notification system currently exists.

## Related

- PRD: [`PRD Purchasing Request.md`](../../PRD%20Purchasing%20Request.md)
- Migration: `database/migration_purchase_request.sql`
- Role mapping: see `CLAUDE.md` §4.2 — `staff` is Project Admin, `purchasing_admin` is Purchasing Admin.
