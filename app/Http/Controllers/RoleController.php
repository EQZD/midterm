<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function show(Role $role)
    {
        $role->load('users');
        return view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $users    = User::all();
        $assigned = $role->users->pluck('id')->toArray();
        return view('admin.roles.edit', compact('role', 'users', 'assigned'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'display_name' => 'required|string|max:255',
            'description'  => 'nullable|string|max:500',
            'user_ids'     => 'nullable|array',
            'user_ids.*'   => 'exists:users,id',
        ]);

        $role->update([
            'display_name' => $request->display_name,
            'description'  => $request->description,
        ]);

        if ($request->has('user_ids')) {
            $role->users()->sync($request->user_ids);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role updated.');
    }

}