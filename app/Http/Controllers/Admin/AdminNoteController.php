<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminNoteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'body' => 'required|string|max:5000',
            'visibility' => 'required|in:private,team,public',
        ]);


// dd($request->all());
        AdminNote::create([
            'ticket_id' => $request->ticket_id,
            'ticket_track_id' => $request->ticket_track_id,
            'client_id' => $request->client_id ?? null,
            'created_by' => auth()->id(),
            // 'created_by'=>1,
            'has_attachments'=>false,
            'title' => $request->title,
            'body' => $request->body,
            'note_type' => $request->note_type ?? 'ticket',
            'visibility' => $request->visibility,
        ]);

        return back()->with('success', 'Note added successfully!');
    }
}
