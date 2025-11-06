<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppUser;
use App\Models\SiteUser;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketMainCategory;
use App\Models\TicketSubcategory;
use App\Models\TicketService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    /**
     * Display all tickets.
     */
    public function index()
    {
        $tickets = Ticket::with(['category',  'siteUser.activeSubscription.plan', 'subcategory', 'service', 'siteUser', 'assignee'])
            ->latest()
            ->paginate(10);

        return view('admin.tickets.index', compact('tickets'));
    }
    public function updateStatus(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'status' => 'nullable|in:New,Open,In Progress,On Hold,Waiting for Customer,Resolved,Closed,Reopened',
        ]);

        $ticket = Ticket::find($request->ticket_id);
        if (!$ticket) {
            return response()->json(['success' => false, 'message' => 'Ticket not found.']);
        }

        $ticket->status = $request->status;

        if ($ticket->save()) {
            return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Failed to save status.']);
    }


    public function updatePriority(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'priority' => 'nullable|in:Low,Medium,High,Urgent,Critical',
        ]);

        $ticket = Ticket::find($request->ticket_id);
        if (!$ticket) {
            return response()->json(['success' => false, 'message' => 'Ticket not found.']);
        }

        $ticket->priority = $request->priority;

        if ($ticket->save()) {
            return response()->json(['success' => true, 'message' => 'Priority updated successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Failed to save priority.']);
    }

    public function create()
    {
        $categories = TicketMainCategory::all();
        $subcategories = TicketSubcategory::all();
        $services = TicketService::all();
        // $users = User::all();/
        $siteUsers = SiteUser::all();

        return view('admin.tickets.create', compact('categories', 'subcategories', 'services', 'siteUsers'));
    }


    public function store(Request $request)
    {
        // 🔹 Validation
        $validated = $request->validate([
            'ticket_user'       => 'required|exists:site_user,id',
            'cat_id'            => 'nullable|exists:ticket_main_categories,id',
            'services_cat_id'   => 'nullable|exists:ticket_subcategories,id',
            'services'          => 'nullable|exists:ticket_services,id',
            'service_url'       => 'nullable|url|max:255',
            'title'             => 'required|string|max:150',
            'ticket_body'       => 'required|string',
            'priority'          => 'nullable|in:Low,Medium,High,Urgent',
            'assigned_to'       => 'nullable|exists:app_user,id',
            'attachments.*'     => 'nullable|file|max:5120', // 5MB each
        ]);

        // 🔹 Create ticket
        $ticket = Ticket::create([
            'ticket_track_id'       => strtoupper(Str::random(12)),
            'cat_id'                => $validated['cat_id'] ?? null,
            'services_cat_id'       => $validated['services_cat_id'] ?? null,
            'services'              => $validated['services'] ?? null,
            'service_url'           => $validated['service_url'] ?? null,
            'title'                 => $validated['title'],
            'ticket_body'           => $validated['ticket_body'],
            'ticket_user'           => $validated['ticket_user'],
            'user_type'             => 'A', // A = created by admin
            'status'                => 'New',
            'priority'              => $validated['priority'] ?? 'Medium',
            'assigned_to'           => null,
            'assigned_date'         => null,
            'opened_time'           => now(),
        ]);

        // 🔹 File uploads (optional)
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store("tickets/{$ticket->id}", 'public');

                TicketAttachment::create([
                    'ticket_id'   => $ticket->id,
                    'file_name'   => $file->getClientOriginalName(),
                    'file_path'   => $path,
                    'file_type'   => $file->getMimeType(),
                    'uploaded_by' => auth()->id(),
                ]);
            }
        }

        // 🔹 Redirect with success
        return redirect()
            ->route('admin.tickets.index')
            ->with('success', 'Ticket created successfully.');
    }

    public function show(Ticket $ticket, $id)
    {

        $ticket = Ticket::findOrFail($id);
        $ticket->load(['attachments', 'category', 'subcategory', 'service', 'siteUser', 'assignee']);
        return view('admin.tickets.show', compact('ticket'));
    }

    /**
     * Show form to edit ticket.
     */
    public function edit(Ticket $ticket, $id)
    {
        // dd($id);
        $categories = TicketMainCategory::all();
        $subcategories = TicketSubcategory::all();
        $services = TicketService::all();
        $siteUsers = SiteUser::all();
        $ticket = Ticket::findOrFail($id);

        return view('admin.tickets.edit', compact('ticket', 'categories', 'subcategories', 'services', 'siteUsers'));
    }

    /**
     * Update the specified ticket.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'ticket_body' => 'required|string',
            'status' => 'required|string',
            'priority' => 'required|string',
            'assigned_to' => 'nullable|exists:app_user,id',
            'attachments.*' => 'file|max:5120',
        ]);
        $ticket = Ticket::findOrFail($id);
        $ticket->update($request->only([
            'title',
            'ticket_body',
            'status',
            'priority',
            'assigned_to',
            'cat_id',
            'services_cat_id',
            'services'
        ]));

        // Upload new attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('tickets/' . $ticket->id, 'public');
                TicketAttachment::create([
                    'ticket_id' => $ticket->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getMimeType(),
                    'uploaded_by' => auth()->id(),
                ]);
            }
        }

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket updated successfully.');
    }

    /**
     * Delete ticket and its attachments.
     */
    public function destroy(Ticket $ticket, $id)
    {
        // Delete attachments from storage
        foreach ($ticket->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
            $attachment->delete();
        }
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket deleted successfully.');
    }

    public function getSubcategories($categoryId)
    {
        $subcategories = TicketSubcategory::where('main_category_id', $categoryId)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json($subcategories);
    }

    // ✅ Get all services for a subcategory
    public function getServices($subcatId)
    {
        $services = TicketService::where('subcategory_id', $subcatId)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json($services);
    }

    public function setAssign($id)
    {
        $ticket = Ticket::findOrFail($id);
        $siteUsers = SiteUser::all();
        $appUser = AppUser::all();
        return view('admin.tickets.set_assign', compact('ticket', 'appUser', 'siteUsers'));
    }

    public function updateAssign(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->update([
            // 'category_id' => $request->category_id,
            // 'subcategory_id' => $request->subcategory_id,
            // 'service_id' => $request->service_id,
            'assigned_to' => $request->assigned_to,
            'assigned_date' => now(),
        ]);

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket assigned successfully!');
    }
}
