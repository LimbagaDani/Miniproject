<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Task Manager</title>
    <style>
        :root {
            --bg: #f3f6fb;
            --panel: #ffffff;
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --success: #059669;
            --warning: #f59e0b;
            --danger: #dc2626;
            --text: #1f2937;
            --muted: #6b7280;
            --border: #dfe7f3;
            --shadow: 0 15px 35px rgba(15, 23, 42, 0.08);
        }

        * { box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: linear-gradient(135deg, #edf4ff 0%, #f7f9fd 100%);
            color: var(--text);
        }

        .page {
            max-width: 1220px;
            margin: 0 auto;
            padding: 32px 20px 50px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            gap: 16px;
            flex-wrap: wrap;
        }

        h1 {
            margin: 0;
            font-size: 2.2rem;
        }

        .subheading {
            color: var(--muted);
            margin-top: 6px;
            font-size: 1rem;
        }

        .panel {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: var(--shadow);
            padding: 24px;
        }

        .add-task-panel {
            margin-bottom: 28px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            align-items: end;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        label {
            font-weight: 700;
            font-size: 0.96rem;
        }

        input, textarea, select, button {
            font: inherit;
        }

        input, textarea, select {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 12px 13px;
            background: #fff;
            color: var(--text);
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .btn {
            border: none;
            border-radius: 10px;
            padding: 12px 18px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover { background: var(--primary-dark); }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
        }

        .btn-danger {
            background: #fee2e2;
            color: var(--danger);
            padding: 9px 12px;
        }

        .alert {
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-weight: 600;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .task-list {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .task-list th,
        .task-list td {
            padding: 15px 12px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            vertical-align: top;
        }

        .task-list thead {
            background: #f8fafc;
        }

        .task-list th {
            font-size: 0.8rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .task-name {
            font-weight: 700;
            color: var(--text);
            margin-bottom: 6px;
        }

        .task-description {
            color: var(--muted);
            font-size: 0.92rem;
            line-height: 1.5;
            max-width: 380px;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-completed {
            background: #dcfce7;
            color: #166534;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .action-link {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }

        .status-form select {
            min-width: 130px;
        }

        .empty-state {
            text-align: center;
            color: var(--muted);
            padding: 28px 12px;
            font-size: 1.04rem;
        }

        @media (max-width: 768px) {
            .page { padding: 24px 16px 36px; }
            .panel { padding: 18px; }
            .task-list { display: block; overflow-x: auto; }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            <div>
                <h1>Personal Task Manager</h1>
                <div class="subheading">Track your tasks, deadlines, and completion status.</div>
            </div>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ New Task</a>
        </div>

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

        <div class="panel add-task-panel">
            <h2 style="margin-top:0; margin-bottom:18px;">Add Task</h2>
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="field">
                        <label for="task_name">Task Name</label>
                        <input id="task_name" name="task_name" type="text" value="{{ old('task_name') }}" required>
                    </div>

                    <div class="field">
                        <label for="description">Description</label>
                        <textarea id="description" name="description">{{ old('description') }}</textarea>
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

                    <div class="field">
                        <button type="submit" class="btn btn-primary">Add Task</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="panel">
            <h2 style="margin-top:0; margin-bottom:18px;">Your Tasks</h2>

            <table class="task-list" aria-label="Task list">
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
                                <div class="task-name">{{ $task->task_name }}</div>
                            </td>
                            <td>
                                <div class="task-description">
                                    {{ $task->description ?: 'No description added.' }}
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-{{ strtolower($task->status) }}">{{ $task->status }}</span>
                            </td>
                            <td>
                                {{ $task->due_date ? date('M d, Y', strtotime($task->due_date)) : 'No due date' }}
                            </td>
                            <td>
                                <form action="{{ route('tasks.status', $task) }}" method="POST" class="status-form">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="Pending" {{ $task->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Completed" {{ $task->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <div class="actions">
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
                            <td colspan="6" class="empty-state">No tasks yet. Add your first task above.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
