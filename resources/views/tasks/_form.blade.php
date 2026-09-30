@csrf

<div class="mb-3">
    <label class="form-label fw-semibold">Task Name</label>
    <input type="text" name="task" class="form-control" placeholder="e.g. Finish project report"
           value="{{ old('task', $task->task ?? '') }}" required>
    @error('task') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Date</label>
        <input type="date" name="date" class="form-control"
               value="{{ old('date', $task->date ?? '') }}" required>
        @error('date') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Time</label>
        <input type="time" name="time" class="form-control"
               value="{{ old('time', isset($task) ? substr($task->time, 0, 5) : '') }}" required>
        @error('time') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Priority</label>
    <select name="priority" class="form-select">
        @php $currentPriority = old('priority', $task->priority ?? 'medium'); @endphp
        <option value="low" {{ $currentPriority === 'low' ? 'selected' : '' }}>🟢 Low</option>
        <option value="medium" {{ $currentPriority === 'medium' ? 'selected' : '' }}>🟡 Medium</option>
        <option value="high" {{ $currentPriority === 'high' ? 'selected' : '' }}>🔴 High</option>
    </select>
    @error('priority') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="mb-4">
    <label class="form-label fw-semibold">Note</label>
    <div id="editor" style="height: 180px; background: white;">{!! old('note', $task->note ?? '') !!}</div>
    <input type="hidden" name="note" id="note-input" value="{{ old('note', $task->note ?? '') }}">
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-success flex-fill flex-md-grow-0 px-4">Save Task</button>
    <a href="{{ route('tasks.index') }}" class="btn btn-secondary flex-fill flex-md-grow-0 px-4">Cancel</a>
</div>

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<style>
    #editor { border-radius: 0 0 12px 12px; }
    .ql-toolbar { border-radius: 12px 12px 0 0; background: #fafafe; }
    .ql-container { border-radius: 0 0 12px 12px; }
</style>
<script>
    const quill = new Quill('#editor', { theme: 'snow' });

    document.querySelector('form').addEventListener('submit', function () {
        document.querySelector('#note-input').value = document.querySelector('#editor').querySelector('.ql-editor').innerHTML;
    });
</script>
@endpush