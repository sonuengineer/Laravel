<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Services\DjangoRuleService;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            return Task::all();
        }

        return Task::where('assigned_to', auth()->id())->get();
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Only admin can assign tasks'], 403);
        }

        $request->validate([
            'title' => 'required',
            'assigned_to' => 'required',
            'due_date' => 'required|date',
        ]);

        return Task::create([
            'title' => $request->title,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'assigned_to' => $request->assigned_to,
            'project_id' => $request->project_id,
            'status' => 'TODO',
        ]);
    }

    public function updateStatus(
        Request $request,
        Task $task,
        DjangoRuleService $service
    ) {
        $request->validate([
            'status' => 'required|in:TODO,IN_PROGRESS,DONE'
        ]);

        if (
            Carbon::parse($task->due_date)->isPast()
            && auth()->user()->role !== 'admin'
        ) {
            return response()->json([
                'error' => 'Task overdue. Only admin can update.'
            ], 403);
        }

        $result = $service->validate([
            'current_status' => $task->status,
            'new_status' => $request->status,
            'due_date' => $task->due_date,
            'role' => auth()->user()->role,
        ]);

        if (!$result['valid']) {
            return response()->json(['error' => $result['message']], 403);
        }

        $task->update(['status' => $request->status]);

        return response()->json($task);
    }

    public function updateDueDate(Request $request, Task $task)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Only admin'], 403);
        }

        $request->validate([
            'due_date' => 'required|date'
        ]);

        $task->update(['due_date' => $request->due_date]);

        return response()->json($task);
    }
}
