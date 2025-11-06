<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;


class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::orderBy('created_at', 'desc')->get();
        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        // Validate required fields
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'slug' => 'required|string|max:100|unique:plans,slug',
            'price' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'duration_days' => 'required|integer|min:1',
            'billing_cycle' => 'required|in:monthly,yearly,one-time',
            'trial_days' => 'nullable|integer|min:0',
            'max_users' => 'nullable|integer|min:0',
            'max_storage_gb' => 'nullable|integer|min:0',
            'max_projects' => 'nullable|integer|min:0',
            'border_color' => 'nullable|string|max:20',
            'title_color' => 'nullable|string|max:20',
            'background_color' => 'nullable|string|max:20',
            'badge_label' => 'nullable|string|max:50',
            'renewal_type' => 'nullable|in:auto,manual',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'features' => 'nullable|json',
        ]);

        // Fill optional fields with defaults if not provided
        $data = array_merge($validated, [
            'currency' => $request->input('currency', 'USD'),
            'border_color' => $request->input('border_color', '#007bff'),
            'title_color' => $request->input('title_color', '#000000'),
            'background_color' => $request->input('background_color', '#f8f9fa'),
            'trial_days' => $request->input('trial_days', 0),
            'is_featured' => $request->has('is_featured') ? $request->input('is_featured') : 0,
            'is_active' => $request->has('is_active') ? $request->input('is_active') : 1,
        ]);

        // Create the plan
        Plan::create($data);

        return redirect()->route('admin.plans.index')->with('success', 'Plan created successfully.');
    }


    public function edit($id)
    {

        $plan = Plan::findOrFail($id);
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        // Validate required and optional fields
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'slug' => 'required|string|max:100|unique:plans,slug,' . $id,
            'price' => 'required|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'duration_days' => 'required|integer|min:1',
            'billing_cycle' => 'required|in:monthly,yearly,one-time',
            'trial_days' => 'nullable|integer|min:0',
            'max_users' => 'nullable|integer|min:0',
            'max_storage_gb' => 'nullable|integer|min:0',
            'max_projects' => 'nullable|integer|min:0',
            'border_color' => 'nullable|string|max:20',
            'title_color' => 'nullable|string|max:20',
            'background_color' => 'nullable|string|max:20',
            'badge_label' => 'nullable|string|max:50',
            'renewal_type' => 'nullable|in:auto,manual',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'features' => 'nullable|json',
        ]);

        // Merge optional fields with defaults if not provided
        $data = array_merge($validated, [
            'currency' => $request->input('currency', $plan->currency ?? 'USD'),
            'border_color' => $request->input('border_color', $plan->border_color ?? '#007bff'),
            'title_color' => $request->input('title_color', $plan->title_color ?? '#000000'),
            'background_color' => $request->input('background_color', $plan->background_color ?? '#f8f9fa'),
            'trial_days' => $request->input('trial_days', $plan->trial_days ?? 0),
            'is_featured' => $request->has('is_featured') ? $request->input('is_featured') : ($plan->is_featured ?? 0),
            'is_active' => $request->has('is_active') ? $request->input('is_active') : ($plan->is_active ?? 1),
        ]);

        $plan = Plan::findOrFail($id);
        $plan->update($data);

        return redirect()->route('admin.plans.index')->with('success', 'Plan updated successfully.');
    }


    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('admin.plans.index')->with('success', 'Plan deleted successfully.');
    }
}
