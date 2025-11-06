<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {

        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function  create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:100|unique:users',
            'email' => 'required|email|max:150|unique:users',
            'password' => 'required|min:6',
            'full_name' => 'nullable|string|max:150',
            'title' => 'nullable|string|max:50',
            'contact_number' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female,Other',
            'dob' => 'nullable|date',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
            'zip' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'timezone' => 'nullable|string|max:50',
            'status' => 'required|in:Active,Inactive,Pending',
            'is_enable_chat' => 'boolean',
            'profile_img' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('profile_img')) {
            $validated['profile_img'] = $request->file('profile_img')->store('profiles', 'public');
        }

        $validated['password'] = Hash::make($request->password);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    public function edit($id)
    {

        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }




    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:100|unique:users,username,' . $id,
            'email' => 'required|email|max:150|unique:users,email,' . $id,
            'password' => 'required|min:6',
            'full_name' => 'nullable|string|max:150',
            'title' => 'nullable|string|max:50',
            'contact_number' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female,Other',
            'dob' => 'nullable|date',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
            'zip' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'timezone' => 'nullable|string|max:50',
            'status' => 'required|in:Active,Inactive,Pending',
            'is_enable_chat' => 'boolean',
            'profile_img' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('profile_img')) {
            $validated['profile_img'] = $request->file('profile_img')->store('profiles', 'public');
        }
       if ($request->filled('password')) {
        $validated['password'] = bcrypt($request->password);
    } else {
        unset($validated['password']);
    }
        $user = User::findOrFail($id);
        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }
    public function status($id)
    {
        $user = User::findOrFail($id);
        if ($user->status === 'Active') {
            $user->status = 'Inactive';
        } else {
            $user->status = 'Active';
        }
        $user->save();
        return back()->with('success', 'User status updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'User deleted successfully!');
    }


 

}
