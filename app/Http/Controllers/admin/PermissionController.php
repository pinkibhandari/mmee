<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    // 👉 List
    public function index(Request $request)
{
    $query = Permission::query();

    // 🔍 Search
    if ($request->search) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    $permissions = $query->latest()->paginate(10);

    return view('admin.permissions.index', compact('permissions'));
}

    // 👉 Create
    public function create()
    {
        return view('admin.permissions.form');
    }

    // 👉 Store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name'
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission Created');
    }

    // 👉 Edit
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('admin.permissions.form', compact('permission'));
    }

    // 👉 Update
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:permissions,name,' . $id
        ]);

        $permission->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission Updated');
    }

    // 👉 Delete
    public function destroy($id)
    {
        Permission::findOrFail($id)->delete();
        return back()->with('success', 'Permission Deleted');
    }
}
