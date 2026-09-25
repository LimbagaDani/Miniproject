<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow Dashboard</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            :root {
                --bg: #f4f7fb;
                --bg-strong: #eaf0ff;
                --panel: rgba(255, 255, 255, 0.92);
                --panel-border: rgba(148, 163, 184, 0.18);
                --primary: #2563eb;
                --primary-dark: #1d4ed8;
                --success: #10b981;
                --warning: #f59e0b;
                --danger: #ef4444;
                --text: #0f172a;
                --muted: #475569;
                --shadow: 0 18px 40px rgba(15, 23, 42, 0.14);
            }

            * { box-sizing: border-box; }
            html { scroll-behavior: smooth; }
            body {
                margin: 0;
                min-height: 100vh;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, var(--bg-strong) 0%, #f8fafc 30%, #eef2ff 100%);
                color: var(--text);
            }
            button, input, select, textarea { font: inherit; }
            button { cursor: pointer; }
            .page-shell { max-width: 1200px; margin: 0 auto; padding: 32px 20px 48px; }
            .topbar { display: flex; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 28px; flex-wrap: wrap; }
            .brand { display: flex; align-items: center; gap: 14px; }
            .brand-mark {
                width: 48px; height: 48px; display: grid; place-items: center; border-radius: 15px;
                background: linear-gradient(135deg, #2563eb, #60a5fa); color: white; font-weight: 800;
                box-shadow: 0 12px 24px rgba(37, 99, 235, 0.35);
            }
            .brand-copy h1 { margin: 0; font-size: clamp(1.9rem, 3vw, 2.6rem); letter-spacing: -0.06em; }
            .brand-copy p { margin: 5px 0 0; color: var(--muted); font-size: 0.98rem; }
            .header-actions { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
            .btn {
                border: 0; border-radius: 12px; padding: 11px 18px; font-weight: 700; text-decoration: none;
                display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: transform 0.2s ease;
            }
            .btn:hover { transform: translateY(-1px); }
            .btn-primary { background: linear-gradient(135deg, var(--primary), #3b82f6); color: white; box-shadow: 0 12px 24px rgba(37, 99, 235, 0.28); }
            .btn-secondary { background: #e2e8f0; color: var(--text); }
            .btn-danger { background: #fee2e2; color: #b91c1c; padding: 9px 12px; }
            .btn-ghost { background: transparent; color: var(--muted); border: 1px solid rgba(148, 163, 184, 0.4); }
            .summary-grid { display: grid; grid-template-columns: repeat(3, minmax(180px, 1fr)); gap: 18px; margin-bottom: 26px; }
            .stat-card { background: rgba(255,255,255,0.8); border: 1px solid var(--panel-border); border-radius: 20px; padding: 22px 18px; box-shadow: var(--shadow); }
            .stat-label { color: var(--muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 10px; display: block; }
            .stat-value { font-size: clamp(1.8rem, 3vw, 2.35rem); font-weight: 800; line-height: 1.2; margin-bottom: 5px; }
            .stat-note { color: var(--muted); font-size: 0.9rem; }
            .panel { background: rgba(255,255,255,0.85); border: 1px solid var(--panel-border); border-radius: 24px; box-shadow: var(--shadow); padding: 24px; }
            .task-form { display: grid; grid-template-columns: 1.3fr 1.2fr 0.8fr 0.9fr auto; gap: 14px; align-items: end; }
            .field { display: flex; flex-direction: column; gap: 8px; }
            .field label { font-weight: 700; color: var(--muted); font-size: 0.9rem; }
            .field input, .field textarea, .field select { width: 100%; border: 1px solid rgba(148,163,184,0.6); border-radius: 12px; background: #f8fafc; color: var(--text); padding: 12px 14px; }
            .field textarea { min-height: 110px; resize: vertical; }
            .field input:focus, .field textarea:focus, .field select:focus { outline: none; border-color: rgba(37,99,235,0.8); box-shadow: 0 0 0 3px rgba(59,130,246,0.15); background: white; }
            .table-header { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin: 24px 0 16px; flex-wrap: wrap; }
            .table-header h2 { margin: 0; font-size: 1.5rem; }
            .filter-toolbar { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
            .filter-toolbar input, .filter-toolbar select { border: 1px solid rgba(148,163,184,0.6); border-radius: 10px; background: #f8fafc; padding: 9px 12px; color: var(--text); }
            .task-table { width: 100%; border-collapse: collapse; background: white; }
            .task-table th, .task-table td { padding: 16px 14px; border-bottom: 1px solid rgba(148,163,184,0.22); text-align: left; vertical-align: top; }
            .task-table thead { background: #f8fafc; }
            .task-table th { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--muted); }
            .task-title { font-weight: 800; font-size: 1.02rem; margin: 0 0 3px; }
            .task-description { color: var(--muted); line-height: 1.5; max-width: 340px; }
            .status-badge { display: inline-flex; align-items: center; justify-content: center; padding: 7px 12px; border-radius: 999px; font-size: 0.78rem; font-weight: 700; }
            .status-pending { background: #fef3c7; color: #92400e; }
            .status-completed { background: #dcfce7; color: #166534; }
            .task-date { color: var(--muted); font-weight: 600; }
            .inline-status { min-width: 132px; }
            .action-group { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
            .action-link { color: var(--primary); text-decoration: none; font-weight: 700; }
            .empty-state { text-align: center; color: var(--muted); padding: 38px 20px; font-size: 1rem; }
            .alert { padding: 14px 16px; border-radius: 12px; margin-bottom: 18px; font-weight: 600; }
            .alert-success { background: #ecfdf5; color: #065f46; border: 1px solid rgba(16,185,129,0.3); }
            .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid rgba(239,68,68,0.2); }
            @media (max-width: 980px) { .task-form { grid-template-columns: 1fr 1fr; } }
            @media (max-width: 720px) { .page-shell { padding: 20px 14px 40px; } .summary-grid, .task-form { grid-template-columns: 1fr; } .panel { padding: 18px; } .task-table { display: block; overflow-x: auto; } }
        </style>
    @endif
</head>
<body>
    <div class="page-shell">
        <header class="topbar">
            <div class="brand">
                <div class="brand-mark">T</div>
                <div class="brand-copy">
                    <h1>TaskFlow</h1>
                    <p>Personal productivity dashboard</p>
                </div>
            </div>

            <div class="header-actions">
                <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ New Task</a>
            </div>
        </header>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="summary-grid">
            <div class="stat-card">
                <span class="stat-label">Total Tasks</span>
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-note">All tracked items</div>
            </div>
            <div class="stat-card">
                <span class="stat-label">Pending</span>
                <div class="stat-value">{{ $stats['pending'] }}</div>
                <div class="stat-note">Still in progress</div>
            </div>
            <div class="stat-card">
                <span class="stat-label">Completed</span>
                <div class="stat-value">{{ $stats['completed'] }}</div>
                <div class="stat-note">Finished tasks</div>
            </div>
        </section>

        <section class="panel">
            <form action="{{ route('tasks.store') }}" method="POST" class="task-form">
                @csrf

                <div class="field">
                    <label for="task_name">Task Name</label>
                    <input id="task_name" name="task_name" type="text" value="{{ old('task_name') }}" placeholder="e.g. Finish project brief" required>
                </div>

                <div class="field">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Add notes or details...">{{ old('description') }}</textarea>
                </div>

                <div class="field">
                    <label for="status">Status</label>
                    <select id="status" name="status">
                        <option value="Pending" {{ old('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Completed" {{ old('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <div class="field">
                    <label for="due_date">Due Date</label>
                    <input id="due_date" name="due_date" type="date" value="{{ old('due_date') }}">
                </div>

                <button type="submit" class="btn btn-primary">Add Task</button>
            </form>
        </section>

        <section class="panel" style="margin-top: 24px;">
            <div class="table-header">
                <h2>Recent Tasks</h2>

                <form method="GET" action="{{ route('tasks.index') }}" class="filter-toolbar">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tasks...">
                    <select name="status_filter">
                        <option value="">All Status</option>
                        <option value="Pending" {{ request('status_filter') === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Completed" {{ request('status_filter') === 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    <button type="submit" class="btn btn-secondary">Filter</button>
                    @if (request('search') || request('status_filter'))
                        <a href="{{ route('tasks.index') }}" class="btn btn-ghost">Clear</a>
                    @endif
                </form>
            </div>

            <table class="task-table" aria-label="Task list">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Update Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tasks as $task)
                        <tr>
                            <td>
                                <div class="task-title">{{ $task->task_name }}</div>
                            </td>
                            <td>
                                <div class="task-description">{{ $task->description ?: 'No description added.' }}</div>
                            </td>
                            <td>
                                <span class="status-badge status-{{ strtolower($task->status) }}">{{ $task->status }}</span>
                            </td>
                            <td>
                                <span class="task-date">{{ $task->due_date ? date('M d, Y', strtotime($task->due_date)) : 'No due date' }}</span>
                            </td>
                            <td>
                                <form action="{{ route('tasks.status', $task) }}" method="POST" class="inline-status">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="inline-status">
                                        <option value="Pending" {{ $task->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Completed" {{ $task->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('tasks.edit', $task) }}" class="action-link">Edit</a>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">No tasks found. Add your first task above.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
