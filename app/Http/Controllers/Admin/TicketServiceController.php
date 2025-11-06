<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketService;
use App\Models\TicketSubcategory;
use App\Models\TicketMainCategory;
use Illuminate\Http\Request;

class TicketServiceController extends Controller
{
    public function index()
    {
        $services = TicketService::with('subcategory.mainCategory')
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.ticket_services.index', compact('services'));
    }

    public function create()
    {
        $mainCategories = TicketMainCategory::where('is_active', true)->get();
        return view('admin.ticket_services.create', compact('mainCategories'));
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'subcategory_id' => 'required|exists:ticket_subcategories,id',
        'name' => 'required|string|max:255',
        'is_active' => 'nullable|boolean',
    ]);

    // ✅ Correctly converts checkbox to true/false
    $validated['is_active'] = $request->boolean('is_active');

    TicketService::create($validated);

    return redirect()->route('admin.ticket_services.index')
        ->with('success', 'Service created successfully.');
}

    public function edit($id)
    {
        $service = TicketService::findOrFail($id);
        $mainCategories = TicketMainCategory::where('is_active', true)->get();
        return view('admin.ticket_services.edit', compact('service', 'mainCategories'));
    }

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'subcategory_id' => 'required|exists:ticket_subcategories,id',
        'name' => 'required|string|max:255',
        'is_active' => 'nullable|boolean',
    ]);

    $validated['is_active'] = $request->boolean('is_active');

    $service = TicketService::findOrFail($id);
    $service->update($validated);

    return redirect()->route('admin.ticket_services.index')
        ->with('success', 'Service updated successfully.');
}
    public function destroy($id)
    {
        $service = TicketService::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.ticket_services.index')
            ->with('success', 'Service deleted successfully.');
    }

    /**
     * AJAX: Get subcategories for selected main category
     */
    public function getSubcategories($mainCategoryId)
    {
        $subcategories = TicketSubcategory::where('main_category_id', $mainCategoryId)
            ->where('is_active', true)
            ->get();

        return response()->json($subcategories);
    }
}
