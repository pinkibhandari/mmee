<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskManagement extends Controller
{
    // 🔹 GET /admin/tasks
    public function index()
    {
        return view('admin.task_managements.index');
    }

    // 🔹 GET /admin/tasks/create
    public function create()
    {
        return view('admin.task_managements.create');
    }

    // 🔹 POST /admin/tasks
    public function store(Request $request)
    {
        // Optional validation (UI testing ke liye useful)
        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);

        // Abhi DB use nahi kar rahe → sirf redirect
        return redirect()->route('admin.tasks.index')
                         ->with('success', 'Task Saved (Static)');
    }

    // 🔹 GET /admin/tasks/{task}
    public function show($id)
    {
        return view('admin.task_managements.show');
    }

    // 🔹 GET /admin/tasks/{task}/edit
    public function edit($id)
    {
        return view('admin.task_managements.edit');
    }

    // 🔹 PUT/PATCH /admin/tasks/{task}
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);

        return redirect()->route('admin.tasks.index')
                         ->with('success', 'Task Updated (Static)');
    }

    // 🔹 DELETE /admin/tasks/{task}
    public function destroy($id)
    {
        return redirect()->route('admin.tasks.index')
                         ->with('success', 'Task Deleted (Static)');
    }
}