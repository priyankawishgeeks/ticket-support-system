<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AppUser;
use App\Models\GlobalAppUserMessage;
use App\Models\GlobalMessage;
use Illuminate\Support\Facades\Auth;

class GlobalAppUserMessageController extends Controller
{
    public function index()
    {
        $currentUser = auth()->user();
        $users = AppUser::where('id', '!=', $currentUser->id)->get();
        $tickets = \App\Models\Ticket::select('id', 'ticket_track_id')->get();

        return view('admin.global_messages.index', compact('users', 'tickets'));
    }

    public function fetchMessages(Request $request)
    {
        $messages = GlobalAppUserMessage::where(function ($q) use ($request) {
            $q->where('sender_id', auth()->id())
                ->where('receiver_id', $request->receiver_id);
        })->orWhere(function ($q) use ($request) {
            $q->where('sender_id', $request->receiver_id)
                ->where('receiver_id', auth()->id());
        })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'receiver_id' => 'required|exists:app_user,id',
            'message' => 'required|string|max:5000',
        ]);

        // dd($request->all());

        $msg = GlobalAppUserMessage::create([
            'sender_id' =>auth()->id(),
            'receiver_id' => $request->receiver_id,
            'ticket_id' => $request->ticket_id ?? null,
            'message' => $request->message,
        ]);

        return response()->json(['success' => true, 'message' => $msg]);
    }
}
