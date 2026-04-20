# Authentication

- **Status:** Implemented
- **Personas:** all (admin, staff, purchasing_admin)

## Purpose

Every user of the WMS must be authenticated before touching inventory data. Downstream features read `role` + `id_gudang` from the session to enforce scoping.

## User stories

- As any **user**, I want to log in with email + password so I can access the dashboard.
- As an **admin**, I want to register new staff accounts and assign them to a warehouse (and role).
- As any **user**, I want to log out cleanly so my session cannot be resumed.

## Acceptance criteria

1. Unauthenticated visitors are redirected to `/login` (default controller).
2. Successful login populates session keys: `is_login`, `id_user`, `nama`, `email`, `role`, `id_gudang`.
3. `id_gudang` is `null` for `role=admin`, otherwise the user's assigned warehouse ID.
4. Only `admin` can access `/register` to create new users.
5. `/logout` destroys the session and redirects to `/login`.
6. Every protected controller calls the login guard in its constructor and flashes `warning` if unauthenticated.

## Routes

| Route | Controller@method | Who |
|---|---|---|
| `GET /` | `Login::index` (default controller) | public |
| `GET /login`, `POST /login` | `Login` | public |
| `GET /logout` | `Logout::index` | authenticated |
| `GET /register`, `POST /register` | `Register` | admin only |

## Data touchpoints

- Reads/writes `user` (email, password hash, `nama`, `role`, `id_gudang`).
- Reads `gudang` for the warehouse-assignment dropdown in registration.
- No stock-counter impact.

## Out of scope

- Password reset / "forgot password".
- Email verification, 2FA, OAuth/SSO.

## Open questions

- Consolidate the duplicated login-guard constructor into `MY_Controller::requireLogin()`?
- Audit password hashing: confirm all entry points use `hashEncrypt()` (which wraps `password_hash`) consistently.
