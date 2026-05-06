<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Site;


class TaskManagement extends Controller
{
    // 🔹 LIST
    public function index()
    {
        $tasks = Task::latest()->paginate(10);
        return view('admin.task_managements.index', compact('tasks'));
    }

    // 🔹 CREATE
   public function create()
{
    $task = null;
    // 👇 sites table se data lao
    $sites = Site::select('id', 'site_name', 'address', 'lat', 'lng')->get();
// dd($sites);

    // preview code
    $lastTask = Task::latest('id')->first();
    $nextId = $lastTask ? $lastTask->id + 1 : 1;

    $previewCode = 'MME-' . date('Y') . '-' . date('m') . '-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

    return view('admin.task_managements.form', compact('task', 'sites', 'previewCode'));
}

    // 🔹 STORE
    public function store(Request $request)
    {
        $data = $this->validateData($request);

        // 👇 Step 1: Create without task_code
        $task = Task::create($data);

        // 👇 Step 2: Generate Task Code
        $taskCode = 'MME-' . date('Y') . '-' . date('m') . '-' . str_pad($task->id, 5, '0', STR_PAD_LEFT);

        // 👇 Step 3: Update task_code
        $task->update([
            'task_code' => $taskCode
        ]);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task Created Successfully');
    }

    // 🔹 SHOW
    public function show(Task $task)
    {
        return view('admin.task_managements.show', compact('task'));
    }

    // 🔹 EDIT
    public function edit(Task $task)
    {
        return view('admin.task_managements.form', compact('task'));
    }

    // 🔹 UPDATE
    public function update(Request $request, Task $task)
    {
        $data = $this->validateData($request);

        $task->update($data);

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task Updated Successfully');
    }

    // 🔹 DELETE
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task Deleted Successfully');
    }

    // 🔹 VALIDATION
    private function validateData($request)
    {
        return $request->validate([
            'task_name'   => 'required|string|max:255',
            'assign_to'   => 'nullable|string|max:255',
            'address'     => 'nullable|string',
            'status'      => 'required|in:0,1',
            'task_type'   => 'nullable|string',
            'title'       => 'nullable|string|max:255',
            'priority'    => 'nullable|string',
            'description' => 'nullable|string',
            'work_note'   => 'nullable|string',
            'due_date'    => 'nullable|date',
            'lat'         => 'nullable',
            'lng'         => 'nullable',
        ]);
    }
}