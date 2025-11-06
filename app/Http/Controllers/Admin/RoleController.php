<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|unique:roles|max:50',
            'description' => 'nullable|string',
        ]);

        Role::create($request->all());
        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {

                $role = Role::findOrFail($id);


        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'role_name' => 'required|max:50|unique:roles,role_name,' . $role->id,
            'description' => 'nullable|string',
        ]);

        $role->update($request->all());
        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role, $id )
    {

       $role= Role::findOrFail($id);
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}