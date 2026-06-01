<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
class RoleController extends Controller
{
    // 👉 List
    public function index()
    {
        $roles = Role::latest()->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    // 👉 Create
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.form', compact('permissions'));
    }

    // 👉 Store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required'
        ]);
        // convert role name
        $roleName = Str::slug($request->name, '_');
         $role = Role::create(['name' =>  $roleName]);
        // $role = Role::create(['name' =>  $request->name]);

        // assign permissions
        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.roles.index')->with('success', 'Role Created');
    }

    // 👉 Edit
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.form', compact('role', 'permissions', 'rolePermissions'));
    }

    // 👉 Update
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'required'
        ]);
         $roleName = Str::slug($request->name, '_');
          $role->update(['name' =>  $roleName]);
 
        // $role->update(['name' => $request->name]);

        // update permissions
        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.roles.index')->with('success', 'Role Updated');
    }

    // 👉 Delete
    public function destroy($id)
    {
        Role::findOrFail($id)->delete();
        return back()->with('success', 'Role Deleted');
    }
}
