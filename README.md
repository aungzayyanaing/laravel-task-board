# Laravel Task Board

A small, single-page task board built with Laravel 13 (PHP 8.3). Tasks are stored in SQLite and shown in three columns — To do, Doing, and Done. There is no sign-in: anyone using the local app sees the same board.

## What you can do

- Add a task with a required title (up to 255 characters) and optional notes. New tasks start in To do.
- Move a task by choosing a status from its dropdown; the form submits when the selection changes.
- Delete a task. The browser asks for confirmation first.
- See validation errors on the page if the title is missing or too long, or the status is invalid.

## What it does not do

- No accounts, login, or per-user boards.
- No editing a task's title or notes after it is created — delete it and add it again.
- No drag-and-drop, due dates, priorities, tags, search, or API. Status changes use a dropdown, not dragging.
- The setup steps below do not seed any tasks, so the board starts empty.

## Requirements

- PHP 8.3
- Composer
- No database server is needed: the default database is SQLite (`database/database.sqlite`).

## Run it

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
# then open http://127.0.0.1:8000
```

`vendor/` and `.env` are intentionally not committed (see `.gitignore`); run `composer install` after cloning.

## How it works

| Method | Route | Name | What it does |
| --- | --- | --- | --- |
| GET | `/` | `tasks.index` | Lists all tasks, newest first |
| POST | `/tasks` | `tasks.store` | Creates a task; title is required (max 255 characters), notes are optional, status is set to `todo` |
| PATCH | `/tasks/{task}` | `tasks.update-status` | Changes a task's status; only `todo`, `doing`, or `done` is accepted |
| DELETE | `/tasks/{task}` | `tasks.destroy` | Deletes a task |

The routes are defined in `routes/web.php` and handled by `app/Http/Controllers/TaskController.php` (`index`, `store`, `updateStatus`, `destroy`).

A task has a title, optional notes, and a status. This is defined in `app/Models/Task.php` — `title`, `notes`, and `status` are fillable, `STATUSES` is `['todo', 'doing', 'done']`, and `isDone()` returns true when the status is `done` — and in `database/migrations/2026_10_25_000000_create_tasks_table.php`, which creates the `tasks` table with `id`, `title` (string), `notes` (text, nullable), `status` (string, default `todo`), and timestamps.

## Project structure

- `app/Http/Controllers/TaskController.php` — list, create, move, and delete tasks
- `app/Models/Task.php` — the task model
- `routes/web.php` — the four task routes
- `resources/views/tasks/index.blade.php` — the board: the add form and the three columns
- `public/css/board.css` — plain CSS for the board; three columns, collapsing to one column below 720px
- `database/migrations/2026_10_25_000000_create_tasks_table.php` — the tasks table

The board is styled with plain CSS and needs no JavaScript build step to run. The unused Laravel Vite/Tailwind scaffold is still in the repo.

## License

MIT — see `LICENSE`.
