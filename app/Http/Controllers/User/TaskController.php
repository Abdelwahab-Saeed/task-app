<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::where('user_id', auth()->id())->with('project');

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $tasks = $query->get();

        return view('user.tasks.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        // Ensure user can only view their own tasks
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $task->load('project');

        return view('user.tasks.show', compact('task'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        // Ensure user can only update their own tasks
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'status' => $task->status
        ]);
    }

    public function toggleAdded(Request $request, Task $task)
    {
        // Ensure user can only toggle their own tasks
        if ($task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $task->update(['is_added' => !$task->is_added]);

        return response()->json([
            'success' => true,
            'message' => 'Dashboard status updated successfully',
            'is_added' => $task->is_added
        ]);
    }
}
