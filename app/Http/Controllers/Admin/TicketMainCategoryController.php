<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TicketMainCategory;

class TicketMainCategoryController extends Controller
{
    public function index()
    {
        $categories = TicketMainCategory::latest()->get();
        return view('admin.ticket_main_categories.index', compact('categories'));
    }
    public function create()
    {
        return view('admin.ticket_main_categories.create');
    }

public function store(Request $request)
{

    // dd($request->all());
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'is_active' => 'nullable|boolean',
    ]);

    $data['is_active'] = $request->boolean('is_active');

    TicketMainCategory::create($data);

    return redirect()->route('admin.ticket_main_categories.index')
        ->with('success', 'Category created successfully!');
}


  
    public function edit($id)
    {
        $category = TicketMainCategory::findOrFail($id);
        return view('admin.ticket_main_categories.edit', compact('category'));
    }

public function update(Request $request, $id)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'is_active' => 'nullable|boolean',
    ]);

    $data['is_active'] = $request->boolean('is_active');

    $category = TicketMainCategory::findOrFail($id);
    $category->update($data);

    return redirect()->route('admin.ticket_main_categories.index')
        ->with('success', 'Category updated successfully!');
}


    /**
     * Delete category.
     */
    public function destroy($id)
    {
        $category = TicketMainCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.ticket_main_categories.index')
            ->with('success', 'Main category deleted successfully!');
    }
}
