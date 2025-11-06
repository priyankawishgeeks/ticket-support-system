<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketMainCategory;
use App\Models\TicketService;
use App\Models\TicketSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\TicketReply;
use Illuminate\Support\Facades\Auth;
use App\Mail\ClientTicketRaised;
use Illuminate\Support\Facades\Mail;

class ClientTicketController extends Controller
{
    public function create()
    {
        $categories = TicketMainCategory::all();

        return view('user.open_ticket', compact('categories'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'title' => 'required|string|max:255',
            'ticket_body' => 'required|string',
            'cat_id' => 'required|integer',
            'priority' => 'required|string',
        ]);
        //    dd(Auth::guard('site_user')->user()->email);

        $ticket = new Ticket;
        $ticket->ticket_user = auth('site_user')->id();
        $ticket->cat_id = $request->cat_id;
        $ticket->services_cat_id = $request->services_cat_id;
        $ticket->services = $request->services;
        $ticket->service_url = $request->service_url;
        $ticket->title = $request->title;
        $ticket->ticket_body = $request->ticket_body;
        $ticket->priority = $request->priority;
        $ticket->ticket_track_id = strtoupper(Str::random(10));
        $ticket->user_type = 'U';
        $ticket->status = 'New';
        $ticket->opened_time = now();

        $ticket->save();

        // dd(auth('site_user')->id());
        $UploadedBy_id = auth('site_user')->id();

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('tickets/' . $ticket->id, 'public');
                TicketAttachment::create([
                    'ticket_id' => $ticket->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                    'file_path' => $path,
                    'uploaded_by' => null,
                ]);
            }
        }



        Mail::to(Auth::guard('site_user')->user()->email)->send(new ClientTicketRaised($ticket));

        


        return redirect()
            ->route('user.open_ticket')
            ->with(['success' => 'Your ticket has been submitted successfully!', 'ticket_id' => $ticket->id]);
    }

    public function showInfo($id)
    {
        $ticket = Ticket::with(['attachments', 'category', 'subcategory', 'service'])
            ->where('id', $id)
            ->where('ticket_user', auth('site_user')->id()) // security: only owner can view
            ->firstOrFail();

        return view('user.ticket_info', compact('ticket'));
    }

    public function show($id)
    {
        // dd('dfghj');
        $ticket = Ticket::with(['attachments', 'category', 'subcategory', 'service'])
            ->where('id', $id)
            ->where('ticket_user', auth('site_user')->id())
            ->firstOrFail();

        return view('user.ticket_detail', compact('ticket'));
    }


    public function reply(Request $request, $id)
    {
        // dd($request->all());
        $ticket = Ticket::findOrFail($id);
        // dd($ticket );
        $request->validate([
            'reply_body' => 'required|string',
            'attachments.*' => 'nullable|file|max:5120',
        ]);

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store("ticket_replies/{$ticket->id}", 'public');
                $attachments[] = [
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                ];
            }
        }

        $reply = TicketReply::create([
            'ticket_id' => $ticket->id,
            'ticket_track_id' => $ticket->ticket_track_id,
            'site_user_id' => auth('site_user')->id(),
            'reply_body' => $request->reply_body,
            'attachments' => $attachments,
            'reply_type' => 'public',
            'created_by_type' => 'site_user',
            'ip_address' => $request->ip(),

        ]);
// dd($reply);
        $ticket->update([
            'last_replied_by' => auth('site_user')->id(),
            'last_replied_by_type' => 'site_user',
            'last_reply_time' => now(),
            'reply_counter' => $ticket->reply_counter + 1,
        ]);


        if ($ticket) {
            Mail::to(Auth::guard('site_user')->user()->email)->send(new ClientTicketRaised($ticket));
        }
// dd($ticket);
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $reply->id,
                'reply_body' => e($reply->reply_body),
                'created_at' => $reply->created_at,
                'attachments' => $attachments,
                'created_by_type' => 'site_user',
                'site_user' => [
                    'name' => Auth::guard('site_user')->user()->username,
                    'email' => Auth::guard('site_user')->user()->email,

                ]
            ]
        ]);
    }


    public function getSubcategories($catId)
    {
        $subcategories = TicketSubcategory::where('main_category_id', $catId)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json($subcategories);
    }

    public function getServices($subId)
    {
        $services = TicketService::where('subcategory_id', $subId)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json($services);
    }


    public function activeTickets()
    {
        $user = Auth::guard('site_user')->user();

        $tickets = Ticket::where('ticket_user', $user->id)
            ->where('user_type', 'U')
            ->withCount('replies') // ✅ counts replies
            ->with(['assignee.role', 'replies' => function ($q) {
                $q->latest(); // ✅ so we can access latest reply easily
            }])
            ->latest()
            ->get();

        return view('user.active_tickets', compact('tickets'));
    }


    public function closedTickets()
    {
        $user = Auth::guard('site_user')->user();

        $tickets = Ticket::where('ticket_user', $user->id)
            ->where('status', 'Closed')
            ->where('user_type', 'U')
            ->latest()
            ->get();

        return view('user.closed_tickets', compact('tickets'));
    }
}
