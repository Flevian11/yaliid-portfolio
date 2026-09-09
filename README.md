# YaliID Portfolio Platform

Clean monorepo for the YaliID personal portfolio, CV, service-request and admin platform.

## Structure

- `frontend/` — React 19 + TypeScript + Vite + Tailwind CSS, deployable as static build output.
- `backend/` — Laravel 13 REST API + MySQL.
- `backend/database/migrations/` — schema definitions. Review and run them locally.

## API

Public API: `/api/v1/*`

Admin API: `/api/v1/admin/*` with Laravel session authentication and the `admin` middleware.

## Frontend environment

Copy `frontend/.env.example` to `.env` and set `VITE_API_URL`.

For a same-origin production deployment, `/api/v1` can remain the default.

## Deployment intent

Build the frontend with `npm run build` and upload the generated `frontend/dist` contents to the cPanel document root. Deploy the Laravel backend separately according to the hosting layout.

No dependency directories are included in this source package.
