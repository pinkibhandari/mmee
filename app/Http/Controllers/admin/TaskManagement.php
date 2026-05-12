<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Site;
use App\Models\User;

class TaskManagement extends Controller
{
    // 🔹 LIST
    public function index(Request $request)
    {
        // Current active tab (default: assigned)
        $status = $request->get('status', 'assigned');

        // Tab counts
        $assignedCount    = Task::where('status', 'assigned')->count();
        $inProgressCount  = Task::where('status', 'in_progress')->count();
        $completedCount   = Task::where('status', 'completed')->count();

        // Filtered & paginated tasks
        $tasks = Task::where('status', $status)
            ->latest()
            ->paginate(10)
            ->appends(['status' => $status]);

        return view('admin.task_managements.index', compact(
            'tasks',
            'status',
            'assignedCount',
            'inProgressCount',
            'completedCount'
        ));
    }

    // 🔹 CREATE
    public function create()
    {
        $task = null;

        $sites = Site::select('id', 'site_name', 'address', 'latitude', 'longitude')->get();

        $users = User::role('users')->get();

        // Preview Task Code
        $lastTask = Task::latest('id')->first();
        $nextId = $lastTask ? $lastTask->id + 1 : 1;

        $previewCode = 'MME' . date('y') . date('m') . str_pad($nextId, 2, '0', STR_PAD_LEFT);

        return view('admin.task_managements.form', compact(
            'task',
            'sites',
            'users',
            'previewCode'
        ));
    }

    // 🔹 STORE
    public function store(Request $request)
    {
        // dd($request->all());
        $data = $this->validateData($request);
        // Auto set creator
        $data['created_by'] = Auth::id();

        // Create Task
        $task = Task::create($data);

        // Generate Task Code
        $taskCode = 'MME' . date('y') . date('m') . str_pad($task->id, 2, '0', STR_PAD_LEFT);

        // Update Task Code
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
        $sites = Site::select('id', 'site_name', 'address', 'latitude', 'longitude')->get();

        $users = User::role('users')->get();

        return view('admin.task_managements.form', compact(
            'task',
            'sites',
            'users'
        ));
    }

    // 🔹 UPDATE
    public function update(Request $request, Task $task)
    {
        $data = $this->validateData($request);

        // created_by overwrite na ho
        unset($data['created_by']);

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
    // private function validateData(Request $request)
    // {
    //     return $request->validate([
    //         'task_name'   => 'required|string|max:255',

    //         'assigned_to' => 'nullable',

    //         'address'     => 'nullable|string',

    //         'status'      => 'required|in: assigned','in_progress','completed',
    //         'task_type'   => 'nullable|string',

    //         'title'       => 'nullable|string|max:255',

    //         'priority'    => 'nullable|string',

    //         'description' => 'nullable|string',

    //         'work_notes'   => 'nullable|string',

    //         'due_date'    => 'nullable|date',

    //         'latitude'         => 'nullable',

    //         'longitude'         => 'nullable',
    //     ]);
    // }
    private function validateData(Request $request)
    {
        return $request->validate([

            'site_id'      => 'nullable|exists:sites,id',

            'task_name'    => 'required|string|max:255',

            'assigned_to'  => 'required',
            'customer_name'  => 'nullable|string|max:255',
            'customer_phone' => 'nullable|digits:10',

            'address'      => 'nullable|string',

            'status'       => 'required|in:assigned,in_progress,completed',

            'task_type'    => 'nullable|string|in:site,manual',

            'title'        => 'nullable|string|max:255',

            'priority'     => 'nullable|in:low,medium,high,urgent',

            'description'  => 'nullable|string',

            'work_notes'   => 'nullable|string',

            'due_date'     => 'nullable|date',

            'latitude'     => 'nullable',

            'longitude'    => 'nullable',
        ]);
    }
}
