<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TicketReplyController extends Controller
{
    public function index($ticketId)
    {
        $ticket = Ticket::with([
            'replies.appUser',
            'replies.siteUser',
            'replies.children.appUser',
            'replies.children.siteUser'
        ])->findOrFail($ticketId);

        return response()->json([
            'success' => true,
            'data' => $ticket->replies
        ]);
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required|exists:tickets,id',
            'reply_body' => 'required|string',
            'attachments.*' => 'file|max:10240',

            'reply_type' => 'in:public,internal',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $ticket = Ticket::findOrFail($request->ticket_id);

        // 🧠 Since this is from admin panel, use default auth()
        $senderType = 'app_user';
        $senderId = auth()->id();
        // dd($senderId);/

        if (!$senderId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: Admin not logged in.'
            ], 401);
        }

        // 📎 Handle attachments
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('ticket_replies', 'public');
                $attachments[] = $path;
            }
        }

        // 💾 Create reply
        $reply = TicketReply::create([
            'ticket_id'         => $ticket->id,
            'ticket_track_id'   => $ticket->ticket_track_id,
            'app_user_id'       => $senderId, // admin user
            'site_user_id'      => $ticket->siteUser?->id,
            'reply_body'        => $request->reply_body,
            'attachments'       => $attachments,
            'reply_type'        => $request->reply_type ?? 'public',
            'created_by_type'   => $senderType,
            'ip_address'        => $request->ip(),
            'user_agent'        => $request->header('User-Agent'),
        ]);

        // Optionally update last reply info in the ticket
        $ticket->update([
            'last_replied_by' => $senderId,
            'last_replied_by_type' => $senderType,
            'last_reply_time' => now(),

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reply added successfully',
            'data' => $reply
        ]);
    }

    public function markAsRead($id)
    {
        $reply = TicketReply::findOrFail($id);
        $reply->update(['is_read' => true, 'read_at' => now()]);

        return response()->json(['success' => true]);
    }

    /**
     * Soft delete a reply
     */
    public function destroy($id)
    {
        $reply = TicketReply::findOrFail($id);
        $reply->delete();

        return response()->json(['success' => true, 'message' => 'Reply deleted']);
    }
}
