<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Board</title>
    <link rel="stylesheet" href="{{ asset('css/board.css') }}">
</head>
<body>
<main class="board">
    <header>
        <h1>Task Board</h1>
        <p>A tiny Laravel task board: add a task, move it across statuses, delete it when done.</p>
    </header>

    @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="add-form" method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <input type="text" name="title" placeholder="New task title" required maxlength="255">
        <input type="text" name="notes" placeholder="Notes (optional)">
        <button type="submit">Add task</button>
    </form>

    <section class="columns">
        @foreach (['todo' => 'To do', 'doing' => 'Doing', 'done' => 'Done'] as $status => $label)
            <div class="column">
                <h2>{{ $label }}</h2>
                @forelse ($tasks->where('status', $status) as $task)
                    <article class="task">
                        <strong>{{ $task->title }}</strong>
                        @if ($task->notes)
                            <p>{{ $task->notes }}</p>
                        @endif
                        <div class="task-actions">
                            <form method="POST" action="{{ route('tasks.update-status', $task) }}">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()">
                                    @foreach (['todo', 'doing', 'done'] as $option)
                                        <option value="{{ $option }}" @selected($task->status === $option)>
                                            {{ ucfirst($option) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                  onsubmit="return confirm('Delete this task?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete">Delete</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <p class="empty">Nothing here yet.</p>
                @endforelse
            </div>
        @endforeach
    </section>
</main>
</body>
</html>
