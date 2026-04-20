# User (Staff) Management

- **Status:** Implemented
- **Personas:** admin (write), all (read-only list)

## Purpose

Admins manage who has access to the WMS: creating accounts, assigning roles (`staff` / `purchasing_admin`), and binding project admins to a specific warehouse.

## User stories

- As an **admin**, I want to register a new staff user with a role and warehouse assignment.
- As an **admin**, I want to edit or deactivate existing users.
- As any **user**, I want to see a list of staff (read-only) for coordination.

## Acceptance criteria

1. `/users` lists all users with pagination.
2. `/register` is admin-only; form captures `nama`, `email`, `password`, `role`, `id_gudang`.
3. `role` must be one of `admin`, `staff`, `purchasing_admin` (validated server-side).
4. If `role=admin`, `id_gudang` is forced to `NULL`.
5. Email uniqueness is enforced.
6. Passwords are hashed with `hashEncrypt()` before insert.

## Routes

| Route | Controller@method | Who |
|---|---|---|
| `GET /users`, `GET /users/(:num)` | `Users::index` | authenticated |
| `GET /user/...` | `User` (edit/delete actions) | admin only |
| `GET /register`, `POST /register` | `Register` | admin only |

## Data touchpoints

- Reads/writes `user`. Reads `gudang` for the assignment dropdown.
- No stock-counter impact.

## Out of scope

- Per-feature permission editor (roles are hardcoded).
- Audit log of user changes.

## Open questions

- Soft-delete vs. hard-delete when deactivating a user — do existing transactions break if `user` rows vanish?
