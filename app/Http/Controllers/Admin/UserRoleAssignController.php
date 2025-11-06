<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserRoleAssignController extends Controller
{
   public function index()
{
    // Only get users with status = 'Active'
    $users = User::with('roles')
        ->where('status', 'Active')
        ->get();

    $roles = Role::all();

    return view('admin.users_role_assign.index', compact('users', 'roles'));
}
        public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        return view('admin.users_role_assign.edit', compact('user', 'roles'));
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'roles' => 'required|array',
        ]);

        $user->roles()->sync($validated['roles']); // detach + attach new roles

        return redirect()->route('admin.user_roles.index')
            ->with('success', 'User roles updated successfully.');
    }
    public function destroy($userId, $roleId)
    {
        $user = User::findOrFail($userId);
        $user->roles()->detach($roleId);
        return back()->with('success', 'Role removed from user.');
    }
}
