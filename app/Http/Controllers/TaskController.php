<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->filled('search')) {
            $query->where('task', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('is_completed', $request->status === 'completed' ? 1 : 0);
        }

        $tasks = $query->orderBy('is_completed')->orderBy('date')->orderBy('time')->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'task' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'note' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        Task::create($data);

        return redirect()->route('tasks.index')->with('success', 'Task added successfully!');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'task' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'note' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        $task->update($data);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }

    public function toggleComplete(Task $task)
    {
        $task->update(['is_completed' => ! $task->is_completed]);

        return redirect()->route('tasks.index')->with('success', $task->is_completed ? 'Task marked as complete!' : 'Task marked as pending!');
    }
}