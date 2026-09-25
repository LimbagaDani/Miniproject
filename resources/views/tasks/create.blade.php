<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            :root { --bg: #f4f7fb; --bg-strong: #eaf0ff; --panel: rgba(255,255,255,0.92); --panel-border: rgba(148,163,184,0.18); --primary: #2563eb; --primary-dark: #1d4ed8; --text: #0f172a; --muted: #475569; --shadow: 0 18px 40px rgba(15,23,42,0.14); }
            * { box-sizing: border-box; }
            body { margin: 0; min-height: 100vh; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, var(--bg-strong) 0%, #f8fafc 30%, #eef2ff 100%); color: var(--text); }
            a, button, input, select, textarea { font: inherit; }
            button { cursor: pointer; }
            .page-shell { max-width: 1200px; margin: 0 auto; padding: 32px 20px 48px; }
            .topbar { display: flex; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 28px; flex-wrap: wrap; }
            .brand { display: flex; align-items: center; gap: 14px; }
            .brand-mark { width: 48px; height: 48px; display: grid; place-items: center; border-radius: 15px; background: linear-gradient(135deg, #2563eb, #60a5fa); color: white; font-weight: 800; box-shadow: 0 12px 24px rgba(37,99,235,0.35); }
            .brand-copy h1 { margin: 0; font-size: clamp(1.9rem, 3vw, 2.6rem); letter-spacing: -0.06em; }
            .brand-copy p { margin: 5px 0 0; color: var(--muted); font-size: 0.98rem; }
            .btn { border: 0; border-radius: 12px; padding: 11px 18px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
            .btn-primary { background: linear-gradient(135deg, var(--primary), #3b82f6); color: white; box-shadow: 0 12px 24px rgba(37,99,235,0.28); }
            .btn-secondary { background: #e2e8f0; color: var(--text); }
            .panel { background: rgba(255,255,255,0.85); border: 1px solid var(--panel-border); border-radius: 24px; box-shadow: var(--shadow); padding: 24px; }
            .task-form { display: grid; grid-template-columns: 1.3fr 1.2fr 0.8fr 0.9fr auto; gap: 14px; align-items: end; }
            .field { display: flex; flex-direction: column; gap: 8px; }
            .field label { font-weight: 700; color: var(--muted); font-size: 0.9rem; }
            .field input, .field textarea, .field select { width: 100%; border: 1px solid rgba(148,163,184,0.6); border-radius: 12px; background: #f8fafc; color: var(--text); padding: 12px 14px; }
            .field textarea { min-height: 110px; resize: vertical; }
            .field input:focus, .field textarea:focus, .field select:focus { outline: none; border-color: rgba(37,99,235,0.8); box-shadow: 0 0 0 3px rgba(59,130,246,0.15); background: white; }
            .alert { padding: 14px 16px; border-radius: 12px; margin-bottom: 18px; font-weight: 600; }
            .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid rgba(239,68,68,0.2); }
            @media (max-width: 980px) { .task-form { grid-template-columns: 1fr 1fr; } }
            @media (max-width: 720px) { .page-shell { padding: 20px 14px 40px; } .task-form { grid-template-columns: 1fr; } .panel { padding: 18px; } }
        </style>
    @endif
</head>
<body>
    <div class="page-shell">
        <div class="topbar" style="margin-bottom: 20px;">
            <div class="brand">
                <div class="brand-mark">+</div>
                <div class="brand-copy">
                    <h1>Create Task</h1>
                    <p>Capture a new item for your day</p>
                </div>
            </div>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back to Dashboard</a>
        </div>

        <div class="panel">
            @if ($errors->any())
                <div class="alert alert-error">
                    <ul style="margin: 0; padding-left: 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tasks.store') }}" method="POST" class="task-form" style="grid-template-columns: 1fr 1fr 0.8fr 0.9fr auto;">
                @csrf

                <div class="field">
                    <label for="task_name">Task Name</label>
                    <input type="text" id="task_name" name="task_name" value="{{ old('task_name') }}" required>
                </div>

                <div class="field">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Write task details...">{{ old('description') }}</textarea>
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
                    <input type="date" id="due_date" name="due_date" value="{{ old('due_date') }}">
                </div>

                <button type="submit" class="btn btn-primary">Save Task</button>
            </form>
        </div>
    </div>
</body>
</html>
