# Dashboard

- **Status:** Implemented
- **Personas:** all

## Purpose

Landing page after login. Shows at-a-glance metrics (stock totals, item counts, warehouse summaries) so users can orient themselves before drilling into a specific module.

## User stories

- As any **user**, I want to see aggregate stock numbers so I know the state of the warehouse(s) I have access to.
- As an **admin**, I want to see totals across all warehouses.
- As **staff**, I want to see totals scoped to my assigned warehouse.

## Acceptance criteria

1. `/home` renders a dashboard with cards for: item count, staff count, warehouse count, total stock qty.
2. For `role=staff`, metrics are scoped to the user's `id_gudang` via `getUserGudangId()` / `isWarehouseRestricted()`.
3. For `role=admin`, metrics aggregate across all warehouses.
4. Numeric helpers (`getJumlahBarang()`, `getJumlahStaff()`, `getJumlahGudang()`, `getTotalStokAllGudang()`, `getWarehouseSummary($id)`) come from `easy_wms_helper.php`.

## Routes

| Route | Controller@method | Who |
|---|---|---|
| `GET /home` | `Home::index` | authenticated |

## Data touchpoints

- Reads `barang`, `user`, `gudang`, `stok_gudang`.
- No writes. No stock-counter mutation.

## Out of scope

- Charts / time-series analytics.
- Per-user activity feed.

## Open questions

- Should the dashboard surface low-stock warnings or pending PR notifications?
