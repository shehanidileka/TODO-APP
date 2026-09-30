@extends('layout')

@section('wrap-class', 'wide')

@section('content')

<div class="stats-row">
    <div class="stat-box">
        <div class="stat-icon">📋</div>
        <div>
            <div class="stat-num">{{ $tasks->count() }}</div>
            <div class="stat-label">Total Tasks</div>
        </div>
    </div>
    <div class="stat-box">
        <div class="stat-icon">✅</div>
        <div>
            <div class="stat-num">{{ $tasks->where('is_completed', true)->count() }}</div>
            <div class="stat-label">Completed</div>
        </div>
    </div>
    <div class="stat-box">
        <div class="stat-icon">🔴</div>
        <div>
            <div class="stat-num">{{ $tasks->where('priority', 'high')->where('is_completed', false)->count() }}</div>
            <div class="stat-label">High Priority</div>
        </div>
    </div>
</div>

<div class="filter-bar mb-3">
    <form method="GET" action="{{ route('tasks.index') }}" class="d-flex flex-wrap gap-2 align-items-center">
        <input type="text" name="search" class="form-control filter-input" placeholder="🔍 Search tasks..."
               value="{{ request('search') }}" style="max-width: 220px;">

        <select name="priority" class="form-select filter-input" style="max-width: 150px;" onchange="this.form.submit()">
            <option value="all" {{ !request('priority') || request('priority') === 'all' ? 'selected' : '' }}>All Priorities</option>
            <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>🔴 High</option>
            <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>🟡 Medium</option>
            <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>🟢 Low</option>
        </select>

        <select name="status" class="form-select filter-input" style="max-width: 150px;" onchange="this.form.submit()">
            <option value="all" {{ !request('status') || request('status') === 'all' ? 'selected' : '' }}>All Status</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
        </select>

        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        @if(request('search') || request('priority') || request('status'))
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-sm">Clear</a>
        @endif
    </form>
</div>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h5 class="mb-0 fw-bold" style="color: #1e1b4b;">Your Tasks</h5>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ Add Task</a>
</div>

@if($tasks->isEmpty())
    <div class="card-panel text-center py-5">
        <div style="font-size: 3rem;">🗒️</div>
        <p class="mt-3 text-muted fw-medium">No tasks found</p>
        <p class="text-muted small">Try adjusting your search or filters</p>
    </div>
@endif

<div class="task-grid">
    @foreach($tasks as $task)
        <div class="task-card priority-{{ $task->priority }} {{ $task->is_completed ? 'completed' : '' }}">
            <div class="task-card-top">
                <span class="task-date-badge">
                    {{ \Carbon\Carbon::parse($task->date)->format('M d') }}
                </span>
                <span class="priority-badge priority-badge-{{ $task->priority }}">
                    {{ ucfirst($task->priority) }}
                </span>
            </div>

            <div class="d-flex align-items-start gap-2">
                <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="mt-1">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="check-btn" title="Toggle complete">
                        {{ $task->is_completed ? '✅' : '⬜' }}
                    </button>
                </form>
                <h6 class="task-card-title mb-0 flex-grow-1">{{ $task->task }}</h6>
            </div>

            <div class="task-card-time mt-2">⏰ {{ \Carbon\Carbon::parse($task->time)->format('h:i A') }}</div>

            @if($task->note)
                <div class="task-card-note">{!! $task->note !!}</div>
            @endif

            <div class="task-card-actions">
                <a href="{{ route('tasks.edit', $task) }}">✏️ Edit</a>

                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="delete-trigger" data-task-name="{{ $task->task }}">🗑️ Delete</button>
                </form>
            </div>
        </div>
    @endforeach
</div>

{{-- Modern Delete Confirmation Modal --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-icon">🗑️</div>
        <h5 class="modal-title">Delete this task?</h5>
        <p class="modal-text">Are you sure you want to delete "<span id="deleteTaskName"></span>"? This action cannot be undone.</p>
        <div class="modal-actions">
            <button type="button" class="btn btn-secondary flex-fill" id="cancelDelete">Cancel</button>
            <button type="button" class="btn btn-delete-confirm flex-fill" id="confirmDelete">Delete</button>
        </div>
    </div>
</div>

<style>
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }

    .stat-box {
        background: #fff;
        border-radius: 16px;
        padding: 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.08);
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: var(--primary-light);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .stat-num {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--text-dark);
        line-height: 1;
    }

    .stat-label {
        font-size: 0.75rem;
        color: #9391c0;
        font-weight: 500;
        margin-top: 2px;
    }

    .filter-bar {
        background: #fff;
        border-radius: 14px;
        padding: 12px 16px;
        box-shadow: 0 4px 16px rgba(99, 102, 241, 0.06);
    }

    .filter-input {
        border-radius: 10px;
        border: 1.5px solid #e6e7f5;
        font-size: 0.85rem;
    }

    .task-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 16px;
    }

    .task-card {
        background: #fff;
        border-radius: 16px;
        padding: 18px;
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.08);
        border: 1px solid #f0f0fa;
        border-left: 4px solid #d1d5db;
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
    }

    .task-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(99, 102, 241, 0.15);
    }

    .task-card.priority-high { border-left-color: #ef4444; }
    .task-card.priority-medium { border-left-color: #f59e0b; }
    .task-card.priority-low { border-left-color: #10b981; }

    .task-card.completed {
        opacity: 0.6;
        background: #fafafa;
    }
    .task-card.completed .task-card-title {
        text-decoration: line-through;
        color: #9391c0;
    }

    .task-card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .task-date-badge {
        background: var(--primary-light);
        color: var(--primary-dark);
        font-size: 0.72rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
    }

    .priority-badge {
        font-size: 0.68rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 20px;
    }
    .priority-badge-high { background: #fee2e2; color: #b91c1c; }
    .priority-badge-medium { background: #fef3c7; color: #92400e; }
    .priority-badge-low { background: #d1fae5; color: #065f46; }

    .check-btn {
        background: none;
        border: none;
        font-size: 1.1rem;
        cursor: pointer;
        padding: 0;
        line-height: 1;
    }

    .task-card-title {
        font-weight: 700;
        color: var(--text-dark);
        font-size: 1rem;
    }

    .task-card-time {
        font-size: 0.8rem;
        color: #8886b8;
        font-weight: 500;
        margin-bottom: 10px;
    }

    .task-card-note {
        font-size: 0.82rem;
        color: #6b6a91;
        border-top: 1px dashed #eceafc;
        padding-top: 10px;
        margin-bottom: 10px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }
    .task-card-note p { margin: 0; }

    .task-card-actions {
        display: flex;
        gap: 12px;
        margin-top: auto;
        padding-top: 8px;
    }
    .task-card-actions a,
    .task-card-actions button {
        background: none;
        border: none;
        font-size: 0.78rem;
        color: #8886b8;
        font-weight: 600;
        cursor: pointer;
        padding: 0;
        text-decoration: none;
    }
    .task-card-actions a:hover { color: var(--primary); }
    .task-card-actions button:hover { color: #ef4444; }

    /* ---------- Modern Delete Modal ---------- */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(30, 27, 75, 0.45);
        backdrop-filter: blur(3px);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    .modal-overlay.show {
        display: flex;
        opacity: 1;
    }

    .modal-box {
        background: #fff;
        border-radius: 20px;
        padding: 28px;
        width: 90%;
        max-width: 360px;
        text-align: center;
        box-shadow: 0 20px 50px rgba(30, 27, 75, 0.25);
        transform: translateY(16px) scale(0.96);
        transition: transform 0.2s ease;
    }
    .modal-overlay.show .modal-box {
        transform: translateY(0) scale(1);
    }

    .modal-icon {
        width: 56px;
        height: 56px;
        margin: 0 auto 14px;
        border-radius: 16px;
        background: #fee2e2;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
    }

    .modal-title {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .modal-text {
        font-size: 0.85rem;
        color: #6b6a91;
        margin-bottom: 20px;
        line-height: 1.5;
    }

    .modal-actions {
        display: flex;
        gap: 10px;
    }

    .btn-delete-confirm {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        padding: 10px;
        transition: all 0.2s ease;
    }
    .btn-delete-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(239, 68, 68, 0.35);
    }

    @media (max-width: 576px) {
        .stats-row { grid-template-columns: 1fr; }
        .task-grid { grid-template-columns: 1fr; }
        .filter-bar form { flex-direction: column; align-items: stretch !important; }
        .filter-input { max-width: 100% !important; }
    }
</style>

<script>
    let formToSubmit = null;

    document.querySelectorAll('.delete-trigger').forEach(function (btn) {
        btn.addEventListener('click', function () {
            formToSubmit = btn.closest('form');
            document.getElementById('deleteTaskName').textContent = btn.dataset.taskName;
            document.getElementById('deleteModal').classList.add('show');
        });
    });

    document.getElementById('cancelDelete').addEventListener('click', function () {
        formToSubmit = null;
        document.getElementById('deleteModal').classList.remove('show');
    });

    document.getElementById('confirmDelete').addEventListener('click', function () {
        if (formToSubmit) formToSubmit.submit();
    });

    document.getElementById('deleteModal').addEventListener('click', function (e) {
        if (e.target === this) this.classList.remove('show');
    });
</script>

@endsection