@extends('layout')

@section('content')
<div class="card-panel" style="max-width: 600px;">
    <h5 class="fw-bold mb-3" style="color: #1e1b4b;">Add New Task</h5>
    <form action="{{ route('tasks.store') }}" method="POST">
        @include('tasks._form')
    </form>
</div>
@endsection