# Data Getter AI

Laravel + Filament dashboard for collecting, reviewing, and later AI-scoring internet scan results.

## Local Setup

This project is intended to run locally at:

```text
http://data-getter-ai.test
```

The Filament dashboard is available at:

```text
http://data-getter-ai.test
```

## Current Stack

- Laravel 12
- Filament 5
- MySQL for local development
- Database-backed sessions, cache, and queues

## Useful Commands

```bash
composer install
php artisan migrate
php artisan filament:make-user
php artisan about
```

For local-only development, the default database is:

```text
data_getter_ai
```

## Project Roadmap

Sprint 1 will add the core dashboard models and demo data:

- Sources
- Scan runs
- Listings with embedded evaluation fields
- Filament CRUD views
- Dashboard widgets
