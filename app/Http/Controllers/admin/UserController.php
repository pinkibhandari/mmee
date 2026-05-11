<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 👉 List
    public function index()
    {
        $users = User::with('roles')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    // 👉 Create
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.form', compact('roles'));
    }

    // 👉 Store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')->with('success', 'User Created');
    }

    // 👉 Edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $userRole = $user->roles->pluck('name')->first();

        return view('admin.users.form', compact('user', 'roles', 'userRole'));
    }

    // 👉 Update
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')->with('success', 'User Updated');
    }

    // 👉 Delete
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User Deleted');
    }
}
