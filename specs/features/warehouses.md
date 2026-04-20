# Warehouse (Gudang) Management

- **Status:** Implemented
- **Personas:** admin (write), all (read-only list)

## Purpose

Warehouses are the scoping unit for staff (`Project Admin`). Every non-admin user is tied to exactly one `id_gudang`, and most transactional features filter data by that ID.

## User stories

- As an **admin**, I want to create, edit, and delete warehouses.
- As an **admin**, I want a summary of each warehouse (item count, total qty).
- As any **user**, I want to see the list of warehouses for coordination.
- As **staff**, I want read-only visibility into other warehouses but write access only to my own (per PRD assumption).

## Acceptance criteria

1. `/warehouses` lists all warehouses; `/warehouses/search` supports text search.
2. `/warehouse/add`, `/warehouse/update`, `/warehouse/delete` are admin-only.
3. Staff viewing a non-assigned warehouse sees action buttons hidden (regression fixed in commit `61e91f3`).
4. Warehouse summary (item count + total qty) comes from `getWarehouseSummary($id)`.
5. Deleting a warehouse must not leave orphaned `stok_gudang` rows (verify cascade or manual cleanup).

## Routes

| Route | Controller@method | Who |
|---|---|---|
| `GET /warehouses`, `/warehouses/(:num)` | `Warehouses::index` | authenticated |
| `GET /warehouses/search[/(:num)]` | `Warehouses::search` | authenticated |
| `GET|POST /warehouse/add` | `Warehouse::add` | admin |
| `POST /warehouse/update` | `Warehouse::update` | admin |
| `POST /warehouse/delete` | `Warehouse::delete` | admin |

## Data touchpoints

- Reads/writes `gudang`.
- Reads `stok_gudang` + `v_ringkasan_gudang` for summaries.
- No direct stock-counter mutation.

## Out of scope

- Multi-location warehouses (one `gudang` row = one physical building).
- Warehouse capacity limits.

## Open questions

- Should deleting a warehouse be soft-delete to preserve historical transactions?
