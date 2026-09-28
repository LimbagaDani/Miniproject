<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
    <style>
        :root {
            --bg-strong: #eaf0ff;
            --panel: rgba(255,255,255,0.9);
            --panel-border: rgba(148,163,184,0.18);
            --primary: #2563eb;
            --text: #0f172a;
            --muted: #475569;
            --shadow: 0 18px 40px rgba(15,23,42,0.14);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--bg-strong) 0%, #f8fafc 30%, #eef2ff 100%);
            color: var(--text);
        }
        .page-shell { max-width: 840px; margin: 0 auto; padding: 40px 20px; }
        .panel { background: var(--panel); border: 1px solid var(--panel-border); border-radius: 24px; box-shadow: var(--shadow); padding: 28px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
        .brand { font-size: 2rem; font-weight: 800; letter-spacing: -0.05em; }
        .btn { border: 0; border-radius: 12px; padding: 11px 18px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; }
        .btn-primary { background: linear-gradient(135deg, var(--primary), #3b82f6); color: white; }
        .btn-secondary { background: #e2e8f0; color: var(--text); }
        .meta { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin: 22px 0; }
        .meta-item { background: #f8fafc; border: 1px solid rgba(148,163,184,0.25); border-radius: 14px; padding: 16px; }
        .label { color: var(--muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 8px; }
        .value { font-size: 1.1rem; font-weight: 700; }
        .description { font-size: 1.05rem; line-height: 1.7; margin-top: 12px; }
        .status-badge { display: inline-flex; align-items: center; justify-content: center; padding: 8px 12px; border-radius: 999px; font-size: 0.78rem; font-weight: 700; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-completed { background: #dcfce7; color: #166534; }
    </style>
</head>
<body>
    <div class="page-shell">
        <div class="topbar">
            <div class="brand">Task Details</div>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back to Dashboard</a>
        </div>

        <div class="panel">
            <h2 style="margin-top: 0; margin-bottom: 8px;">{{ $task->task_name }}</h2>

            <div class="meta">
                <div class="meta-item">
                    <div class="label">Status</div>
                    <div class="value"><span class="status-badge status-{{ strtolower($task->status) }}">{{ $task->status }}</span></div>
                </div>
                <div class="meta-item">
                    <div class="label">Due Date</div>
                    <div class="value">{{ $task->due_date ? date('M d, Y', strtotime($task->due_date)) : 'No due date' }}</div>
                </div>
                <div class="meta-item">
                    <div class="label">Created</div>
                    <div class="value">{{ $task->created_at?->format('M d, Y') ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="label">Description</div>
            <div class="description">{{ $task->description ?: 'No description added for this task.' }}</div>

            <div style="margin-top: 24px; display: flex; gap: 12px; flex-wrap: wrap;">
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary">Edit Task</a>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-secondary">Delete</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
