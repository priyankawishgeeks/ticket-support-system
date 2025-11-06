<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketSubcategory;
use App\Models\TicketMainCategory;
use Illuminate\Http\Request;

class TicketSubcategoryController extends Controller
{
    /**
     * Display a listing of subcategories.
     */
    public function index()
    {
        $subcategories = TicketSubcategory::with('mainCategory')->orderByDesc('id')->paginate(10);
        return view('admin.ticket_subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new subcategory.
     */
    public function create()
    {
        $mainCategories = TicketMainCategory::where('is_active', true)->get();
        return view('admin.ticket_subcategories.create', compact('mainCategories'));
    }

    /**
     * Store a newly created subcategory in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'main_category_id' => 'required|exists:ticket_main_categories,id',
            'name' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        // ✅ Use boolean() to reliably convert checkbox to true/false (1/0)
        $validated['is_active'] = $request->boolean('is_active');

        TicketSubcategory::create($validated);

        return redirect()->route('admin.ticket_subcategories.index')
            ->with('success', 'Subcategory created successfully.');
    }
    /**
     * Show the form for editing the specified subcategory.
     */
    public function edit($id)
    {
        $subcategory = TicketSubcategory::findOrFail($id);
        $mainCategories = TicketMainCategory::where('is_active', true)->get();

        return view('admin.ticket_subcategories.edit', compact('subcategory', 'mainCategories'));
    }

    /**
     * Update the specified subcategory in storage.
     */
    public function update(Request $request, $id)
    {
        $subcategory = TicketSubcategory::findOrFail($id);

        $validated = $request->validate([
            'main_category_id' => 'required|exists:ticket_main_categories,id',
            'name' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        // ✅ Converts correctly: 1 if checked, 0 if unchecked
        $validated['is_active'] = $request->boolean('is_active');

        $subcategory->update($validated);

        return redirect()->route('admin.ticket_subcategories.index')
            ->with('success', 'Subcategory updated successfully.');
    }

    /**
     * Remove the specified subcategory from storage.
     */
    public function destroy($id)
    {
        $subcategory = TicketSubcategory::findOrFail($id);
        $subcategory->delete();

        return redirect()->route('admin.ticket_subcategories.index')
            ->with('success', 'Subcategory deleted successfully.');
    }
}
