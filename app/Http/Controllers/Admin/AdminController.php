<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteUser;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {

        $tickets = Ticket::all();
        $siteUser = SiteUser::with('tickets')->get();


        $ticketCount = Ticket::count();
        $siteUUserCount = SiteUser::count();
        $closedTickets = Ticket::whereNotIn('status', ['Closed'])->count();
        $ticketReplies = TicketReply::with(['ticket', 'appUser', 'siteUser'])
            ->latest()
            ->get();
        // Enrich site user data
        $siteUser = SiteUser::withCount(['tickets', 'ticketReplies'])
            ->withMax('ticketReplies', 'created_at') // latest reply date
            ->orderByDesc('id')
            ->get();
        return view('admin.dashboard', compact('tickets', 'siteUser', 'ticketReplies', 'ticketCount', 'siteUUserCount', 'closedTickets'));
    }

    public function fetchUserDetails(Request $request)
    {
        $user = SiteUser::with([
            'tickets.category',
            'tickets.subcategory',
            'tickets.service',
            'tickets.assignedUser',
            'tickets.replies.siteUser'
        ])->findOrFail($request->id);


        $userHtml = view('partials.client.user_info', compact('user'))->render();
        $ticketsHtml = view('partials.client.user_tickets', compact('user'))->render();

        return response()->json([
            'user_html' => $userHtml,
            'tickets_html' => $ticketsHtml,
        ]);
    }
}
