<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Services\DjangoRuleService;

class TaskController extends Controller
{
    /**
     * List tasks
     * Admin → all tasks
     * User  → only assigned tasks
     */
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            return Task::all();
        }

        return Task::where('assigned_to', auth()->id())->get();
    }

    /**
     * Create task (ADMIN ONLY)
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Only admin can create tasks'], 403);
        }

        $data = $request->validate([
            'title'       => 'required|string',
            'priority'    => 'required|string',
            'due_date'    => 'required|date',
            'assigned_to' => 'required|exists:users,id',
            'project_id'  => 'required|exists:projects,id',
        ]);

        return Task::create([
            ...$data,
            'status' => 'TODO',
        ]);
    }

    /**
     * Update task status (RULE ENGINE CONTROLLED)
     */
    public function updateStatus(
        Request $request,
        Task $task,
        DjangoRuleService $service
    ) {
        $request->validate([
            'status' => 'required|string',
        ]);

        $result = $service->validateTask([
            'current_status' => $task->status,
            'new_status'     => $request->status,
            'due_date'       => $task->due_date,
            'role'           => auth()->user()->role,
        ]);

        // SAFETY: Django service down / invalid
        if (!is_array($result)) {
            return response()->json([
                'error' => 'Rule engine unavailable'
            ], 503);
        }

        if (!$result['valid']) {
            return response()->json([
                'error' => $result['message'] ?? 'Status change not allowed'
            ], 403);
        }

        $task->update([
            'status' => $request->status
        ]);

        return response()->json($task);
    }
}
