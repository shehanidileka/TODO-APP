@extends('layout')

@section('content')
<div class="card-panel" style="max-width: 600px;">
    <h5 class="fw-bold mb-3" style="color: #1e1b4b;">Edit Task</h5>
    <form action="{{ route('tasks.update', $task) }}" method="POST">
        @method('PUT')
        @include('tasks._form')
    </form>
</div>
@endsection