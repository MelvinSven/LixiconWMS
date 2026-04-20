# Supplier Directory

- **Status:** Implemented
- **Personas:** admin, purchasing_admin (write); staff (read)

## Purpose

Suppliers are external vendors the WMS tracks for Purchase Orders and general stock-in reference. They are **not** users in the system — all supplier communication happens outside the platform (per PRD §Assumptions).

## User stories

- As a **purchasing_admin**, I want to add, edit, and deactivate suppliers.
- As a **purchasing_admin**, I want to select a supplier when creating a Purchase Order.
- As any **user**, I want to see the supplier directory (read-only).

## Acceptance criteria

1. `/suppliers` lists all suppliers with pagination + search.
2. Supplier fields: `nama`, contact person, email, phone, address.
3. Soft-delete (deactivate) flag marks a supplier as inactive without removing history.
4. `getSupplierName($id)` returns `'-'` for missing/empty supplier IDs — use this everywhere a supplier name is displayed.

## Routes

| Route | Controller@method | Who |
|---|---|---|
| `GET /suppliers`, `/suppliers/(:num)` | `Suppliers::index` | authenticated |
| `GET /suppliers/search/(:num)` | `Suppliers::search` | authenticated |
| `GET|POST /supplier/...` | `Supplier` (add/edit/delete) | admin, purchasing_admin |

## Data touchpoints

- Reads/writes `supplier`.
- Read via helper `getSuppliers()` / `getSupplierName($id)`.
- No stock-counter mutation.

## Out of scope

- Supplier performance metrics (on-time delivery rate, defect rate) — P2 in PRD, not implemented.
- Supplier self-service portal.

## Open questions

- Deactivation is planned (PRD SUP-03) — is there an `is_active` column on `supplier`, or does it still need a migration?
