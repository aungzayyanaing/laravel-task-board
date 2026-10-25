# Laravel Task Board

A tiny, working task board built on Laravel 13 (PHP 8.3). Add a task,
move it between To do / Doing / Done, delete it when finished. Styled
with plain CSS, no JavaScript build step.

## Run it

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
# then open http://127.0.0.1:8000
```

The default database is SQLite (`database/database.sqlite`), so there
is no database server to set up.

## What is in here

- `app/Models/Task.php` — Task model (title, notes, status)
- `database/migrations/2026_10_25_000000_create_tasks_table.php` — tasks table
- `app/Http/Controllers/TaskController.php` — list, create, move, delete
- `routes/web.php` — the four task routes
- `resources/views/tasks/index.blade.php` — the three-column board
- `public/css/board.css` — board styling, responsive to one column on phones

`vendor/` and `.env` are intentionally not committed (see `.gitignore`):
run `composer install` after cloning.
