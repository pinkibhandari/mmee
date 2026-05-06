<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function taskList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'nullable|in:assigned,in_progress,completed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'status' => false,
                'message' => $validator->errors()->first(),
                'data' => (object) []
            ]);
        }
        $query = Task::where('assigned_to', auth()->id())
            ->with(['logs.files'])
            ->latest();
        // Apply status filter if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $tasks = $query->get();
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => $tasks->isEmpty() ? 'No tasks found' : 'Task list fetched',
            'data' => $tasks->isEmpty() ? [] : TaskResource::collection($tasks)
        ]);
    }

    public function taskDetails($id)
    {
        $task = Task::where('id', $id)
            ->where('assigned_to', auth()->id())
            ->with(['logs.files'])
            ->first();

        if (!$task) {
            return response()->json([
                'code' => 422,
                'status' => false,
                'message' => 'Task not found',
                'data' => (object) []
            ], 422);
        }

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'Task details fetched',
            'data' => new TaskResource($task)
        ]);
    }
}
