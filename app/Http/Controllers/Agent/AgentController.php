<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\CannedMessage;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\SiteUser;
use App\Models\TicketReply;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AgentController extends Controller
{
    public function index()
    {

        $agentId = auth::id();
        // dd($agentId);

        $assingnedTickets = Ticket::where('assigned_to', $agentId)->count();
        // dd($assingnedTickets);      
        $activeTickets = Ticket::where('assigned_to', $agentId)
            ->whereIn('status', ['Open', 'In Progress', 'On Hold', 'Waiting for Customer', 'Reopened'])
            ->count();

        $closedTickets = Ticket::where('assigned_to', $agentId)
            ->where('status', 'Closed')
            ->count();

        $totalUsers = SiteUser::count();

        $assignedSiteUsers = SiteUser::with(['tickets' => function ($q) use ($agentId) {
            $q->where('assigned_to', $agentId);
        }])->whereHas('tickets', function ($q) use ($agentId) {
            $q->where('assigned_to', $agentId);
        })->get();

        $ticketReplies = TicketReply::with(['ticket', 'appUser', 'siteUser'])
            ->whereHas('ticket', function ($q) use ($agentId) {
                $q->where('assigned_to', $agentId);
            })
            ->latest()
            ->get();

        return view('agent.dashboard', compact(
            'assingnedTickets',
            'activeTickets',
            'closedTickets',
            'totalUsers',
            'assignedSiteUsers',
            'ticketReplies'
        ));
    }

    public function tickets()
    {

        $tickets = Ticket::with(['category', 'subcategory', 'service', 'siteUser', 'assignee'])
            ->latest()
            ->paginate(10);


        return view('agent.tickets.index', compact('tickets'));
    }


    function showTicket($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->load(['attachments', 'category', 'subcategory', 'service', 'siteUser', 'assignee']);
        return view('agent.tickets.show', compact('ticket'));
    }


    public function assignedTickets()
    {
        $tickets = Ticket::with(['category', 'subcategory', 'service', 'siteUser', 'assignee'])
            ->where('assigned_to', auth()->id())
            ->latest()
            ->paginate(10);

        return view('agent.tickets.assigned', compact('tickets'));
    }

    public function getUserTickets($id)
    {
        $tickets = Ticket::with(['category', 'subcategory', 'service', 'siteUser', 'assignee'])
            ->where('site_user_id', $id)
            ->latest()
            ->get();

        return view('agent.tickets.user_tickets', compact('tickets'));
    }

    public function siteTicketUser()
    {
        $agentId = Auth::id();

        // ✅ Get only site users whose tickets are assigned to the logged-in agent
        $users = SiteUser::whereHas('tickets', function ($query) use ($agentId) {
            $query->where('assigned_to', $agentId);
        })
            ->with(['tickets' => function ($query) use ($agentId) {
                $query->where('assigned_to', $agentId);
            }])
            ->latest()
            ->paginate(10);

        return view('agent.tickets.user_tickets', compact('users'));
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
            ->orWhere('is_global', true)
            ->with('createdBy')
            ->orderBy('title')
            ->get(['id', 'title', 'subject', 'body', 'is_global']);

        return response()->json($messages);
    }

    public function fetchDetails(Request $request)
    {

        // dd($request->all());
 $user = SiteUser::with([
    'tickets.category',
    'tickets.subcategory',
    'tickets.service',
    'tickets.assignedUser',
    'tickets.replies.siteUser'
])->findOrFail($request->id);



        // dd($user);


        // SECTION 1: Basic User Info
        $userHtml = view('partials.client.user_info', compact('user'))->render();

        // SECTION 2: Tickets + Replies
        $ticketsHtml = view('partials.client.user_tickets', compact('user'))->render();

        return response()->json([
            'user_html' => $userHtml,
            'tickets_html' => $ticketsHtml,
        ]);
    }
}
