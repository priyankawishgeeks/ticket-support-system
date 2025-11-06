<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Exception;

class SiteUserController extends Controller
{
    public function index()
{
    $users = SiteUser::with(['activeSubscription.plan'])
        ->latest()
        ->paginate(15);

    return view('admin.site_user.index', compact('users'));
}

    public function create()
    {
        return view('admin.site_user.create');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                // Basic Info
                'first_name' => 'required|string|max:100',
                'last_name' => 'nullable|string|max:100',
                'username' => 'required|string|max:100|unique:site_user,username',
                'email' => 'required|email|max:150|unique:site_user,email',
                'password' => 'required|min:6',

                // Personal Info
                'gender' => 'nullable|in:Male,Female,Other',
                'dob' => 'nullable|date',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'region' => 'nullable|string|max:100',
                'zip' => 'nullable|string|max:20',
                'country' => 'nullable|string|max:100',

                // Profile Info
                'bio' => 'nullable|string',
                'website' => 'nullable|url|max:255',
                'profile_url' => 'nullable|url|max:255',
                'photo_url' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif|max:2048',

                // Account Info
                'login_type' => 'nullable|in:Normal,Facebook,Google,Twitter,LinkedIn,GitHub,Apple',
                'social_id' => 'nullable|string|max:255',
                'social_data' => 'nullable|json',
                'status' => 'required|in:Active,Inactive,Locked,Suspended',
                'user_type' => 'required|in:Guest,User,Admin',

                // Metadata
                'timezone' => 'nullable|string|max:100',
                'last_ip' => 'nullable|string|max:45',
                'device_info' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Validation failed! Please check your input.');
            }

            // ✅ Collect all valid fields except password & photo
            $data = $request->except(['password', 'photo_url']);
            $data['password'] = Hash::make($request->password);

            // ✅ Default values
            $data['login_type'] = $data['login_type'] ?? 'Normal';
            // $data['join_date'] = now();
            // $data['email_verified_at'] = $request->has('email_verified') ? now() : null;

            // ✅ Handle photo upload
            if ($request->hasFile('photo_url')) {
                $file = $request->file('photo_url');
                if ($file->isValid()) {
                    $path = $file->store('site_users', 'public');
                    $data['photo_url'] = 'storage/' . $path;
                }
            }

            // ✅ Save user
            SiteUser::create($data);

            return redirect()
                ->route('admin.site_user.index')
                ->with('success', 'User created successfully!');
        } catch (Exception $e) {
            Log::error('SiteUser store failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withInput()->with('error', 'Unexpected error occurred while saving user.');
        }
    }


    public function edit($id)
    {
        $user = SiteUser::findOrFail($id);
        return view('admin.site_user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        try {
            $user = SiteUser::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:100',
                'last_name' => 'nullable|string|max:100',
                'username' => 'required|string|max:100|unique:site_user,username,' . $user->id,
                'email' => 'required|email|max:150|unique:site_user,email,' . $user->id,
                'password' => 'nullable|min:6',
                'gender' => 'nullable|in:Male,Female,Other',
                'dob' => 'nullable|date',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'region' => 'nullable|string|max:100',
                'zip' => 'nullable|string|max:20',
                'country' => 'nullable|string|max:100',
                'bio' => 'nullable|string',
                'website' => 'nullable|url|max:255',
                'profile_url' => 'nullable|url|max:255',
                'photo_url' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif|max:2048',
                'status' => 'required|in:Active,Inactive,Locked,Suspended',
                'user_type' => 'required|in:Guest,User,Admin',
                'timezone' => 'nullable|string|max:100',
                'last_ip' => 'nullable|string|max:45',
                'device_info' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Validation failed. Please check your input.');
            }

            $data = $request->except(['password', 'photo_url']);

            // ✅ Update password only if provided
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            // ✅ Handle photo upload
            if ($request->hasFile('photo_url')) {
                $file = $request->file('photo_url');
                if ($file->isValid()) {
                    $path = $file->store('site_users', 'public');
                    $data['photo_url'] = 'storage/' . $path;

                    // Delete old image if exists
                    if ($user->photo_url && file_exists(public_path($user->photo_url))) {
                        @unlink(public_path($user->photo_url));
                    }
                }
            }

            // ✅ Handle optional JSON (social_data)
            if (!empty($data['social_data']) && is_string($data['social_data'])) {
                $json = json_decode($data['social_data'], true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $data['social_data'] = $json;
                } else {
                    unset($data['social_data']);
                }
            }

            $user->update($data);

            return redirect()
                ->route('admin.site_user.index')
                ->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            Log::error('SiteUser update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withInput()->with('error', 'Unexpected error occurred while updating user.');
        }
    }


    public function delete($id)
    {
        $user = SiteUser::findOrFail($id);

        if ($user->photo_url && file_exists(public_path($user->photo_url))) {
            unlink(public_path($user->photo_url));
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully!');
    }

    public function status($id)
    {
        $user = SiteUser::findOrFail($id);
        $user->status = $user->status === 'Active' ? 'Inactive' : 'Active';
        $user->save();

        return back()->with('success', 'User status updated successfully!');
    }
}
