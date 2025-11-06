<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppUser;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;

class AppUserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = AppUser::with('role')->orderByDesc('id')->get();
        return view('admin.app_user.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.app_user.create', compact('roles'));
    }

    public function store(Request $request)
    {


            
        try {
            // ✅ Step 1: Validate inputs
            $validator = Validator::make($request->all(), [
                'user' => 'required|string|max:50|unique:app_user,user',
                'email' => 'required|email|max:150|unique:app_user,email',
                'password' => 'required|min:6',
                'role_id' => 'nullable|exists:roles,id',
                'img_url' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif',
                'gender' => 'nullable|in:Male,Female,Other',
                'status' => 'required|in:Active,Inactive',
                'panel' => 'required|in:A,S,U',
                'is_enable_chat' => 'boolean'
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Validation failed! Please check your input.');
            }

            // ✅ Step 2: Prepare $data correctly
            $data = $request->except(['password', 'img_url']);  
         
            $data['password'] = Hash::make($request->password);
            $data['is_enable_chat'] = $request->input('is_enable_chat', 1);
            $data['add_date'] = now();

            // ✅ Step 3: Handle file upload safely
            if ($request->hasFile('img_url')) {
                $file = $request->file('img_url');
                if ($file->isValid()) {
                    $path = $file->store('users', 'public');
                    $data['img_url'] = 'storage/' . $path;
                } else {
                    return back()
                        ->withInput()
                        ->with('error', 'Uploaded image file is not valid.');
                }
            }

            

            // dd($data);

            // ✅ Step 4: Create user
            AppUser::create($data);

            return redirect()
                ->route('admin.app_user.index')
                ->with('success', 'User created successfully!');
        } catch (Exception $e) {
         
            return back()
                ->withInput()
                ->with('error', 'An unexpected error occurred while saving the user. Please try again later.');
        }
    }


    public function edit($id)
    {
        $user = AppUser::findOrFail($id);
        $roles = Role::all();
        return view('admin.app_user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        try {
            $user = AppUser::findOrFail($id);

            // ✅ Step 1: Validation (same logic as store)
            $validator = Validator::make($request->all(), [
                'user' => 'required|string|max:50|unique:app_user,user,' . $user->id,
                'email' => 'required|email|max:150|unique:app_user,email,' . $user->id,
                'password' => 'nullable|min:6',
                'role_id' => 'nullable|exists:roles,id',
                'img_url' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif|max:2048',
                'gender' => 'nullable|in:Male,Female,Other',
                'status' => 'required|in:Active,Inactive',
                'panel' => 'required|in:A,S,U',
                'is_enable_chat' => 'boolean'
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Validation failed! Please check your input.');
            }

            // ✅ Step 2: Prepare data
            $data = $request->except(['password', 'img_url']);
            $data['is_enable_chat'] = $request->input('is_enable_chat', 1);

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            // ✅ Step 3: Handle image upload (replace old)
            if ($request->hasFile('img_url')) {
                $file = $request->file('img_url');
                if ($file->isValid()) {
                    $path = $file->store('users', 'public');
                    $data['img_url'] = 'storage/' . $path;

                    // Delete old image if exists
                    if ($user->img_url && file_exists(public_path($user->img_url))) {
                        unlink(public_path($user->img_url));
                    }
                }
            }

            // ✅ Step 4: Update user
            $user->update($data);

            return redirect()
                ->route('admin.app_user.index')
                ->with('success', 'User updated successfully!');
        } catch (Exception $e) {
            Log::error('AppUser update failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'An unexpected error occurred while updating the user. Please try again later.');
        }
    }

    public function destroy($id)
    {
        $user = AppUser::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.app_user.index')->with('success', 'User deleted successfully!');
    }
}
