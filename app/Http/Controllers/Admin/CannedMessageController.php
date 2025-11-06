<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CannedMessage;
use App\Models\TicketMainCategory;
use App\Models\TicketSubcategory;
use App\Models\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CannedMessageController extends Controller
{
    /**
     * Display a listing of canned messages.
     */
    public function index()
    {
        $cannedMessages = CannedMessage::with(['createdBy', 'category', 'subcategory', 'service'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.canned_messages.index', compact('cannedMessages'));
    }

    /**
     * Show the form for creating a new canned message.
     */
    public function create()
    {
        $categories = TicketMainCategory::all();
        $subcategories = TicketSubcategory::all();
        $services = TicketService::all();

        return view('admin.canned_messages.create', compact('categories', 'subcategories', 'services'));
    }

    /**
     * Store a newly created canned message in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string',
            'type' => 'required|in:text,html,markdown',
            'category_id' => 'nullable|exists:ticket_main_categories,id',
            'subcategory_id' => 'nullable|exists:ticket_subcategories,id',
            'service_id' => 'nullable|exists:ticket_services,id',
        ]);

        CannedMessage::create([
            'created_by' => auth()->id(), 
            // 'created_by' => 1,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'service_id' => $request->service_id,
            'title' => $request->title,
            'subject' => $request->subject,
            'body' => $request->body,
            'type' => $request->type,
            'is_global' => $request->boolean('is_global'),
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->route('admin.canned_messages.index')->with('success', 'Canned message created successfully.');
    }

    /**
     * Show the form for editing the specified canned message.
     */
    public function edit($id)
    {
        $cannedMessage = CannedMessage::findOrFail($id);
        $categories = TicketMainCategory::all();
        $subcategories = TicketSubcategory::all();
        $services = TicketService::all();

        return view('admin.canned_messages.edit', compact('cannedMessage', 'categories', 'subcategories', 'services'));
    }

    /**
     * Update the specified canned message in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string',
            'type' => 'required|in:text,html,markdown',
        ]);

        $cannedMessage = CannedMessage::findOrFail($id);

        $cannedMessage->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'service_id' => $request->service_id,
            'title' => $request->title,
            'subject' => $request->subject,
            'body' => $request->body,
            'type' => $request->type,
            'is_global' => $request->boolean('is_global'),
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->route('admin.canned_messages.index')->with('success', 'Canned message updated successfully.');
    }

    /**
     * Remove the specified canned message from storage.
     */
    public function destroy($id)
    {
        $cannedMessage = CannedMessage::findOrFail($id);
        $cannedMessage->delete();

        return redirect()->route('admin.canned_messages.index')->with('success', 'Canned message deleted successfully.');
    }

    public function status(Request $request, $id)
    {
        $cannedMessage = CannedMessage::findOrFail($id);
        $cannedMessage->status = $request->status;
        $cannedMessage->save();

        return redirect()->route('admin.canned_messages.index')->with('success', 'Canned message status updated successfully.');
    }


    public function fetch(Request $request)
    {
        $categoryId = $request->get('category_id');
        $subcategoryId = $request->get('subcategory_id');
        $serviceId = $request->get('service_id');

        $messages = CannedMessage::active()
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->when($subcategoryId, fn($q) => $q->where('subcategory_id', $subcategoryId))
            ->when($serviceId, fn($q) => $q->where('service_id', $serviceId))
            ->with('createdBy')
            ->orderBy('title')
            ->get(['id', 'title', 'subject', 'body', 'is_global']);

        return response()->json($messages);
    }
}
