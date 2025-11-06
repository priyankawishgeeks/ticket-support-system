<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteUser;
use App\Models\TicketService;
use App\Models\User;
use App\Models\TicketServiceUser;
use Illuminate\Http\Request;

class TicketServiceUserController extends Controller
{
    // List all service-user links
    public function index()
    {
        $links = TicketServiceUser::with(['service', 'SiteUser'])->latest()->get();
        return view('admin.ticket_service_user.index', compact('links'));
    }

    // Show create form
    public function create()
    {
        $services = TicketService::where('is_active', true)->get();
        // $users = User::all();
        $siteUsers = SiteUser::all();
        return view('admin.ticket_service_user.create', compact('services', 'siteUsers'));
    }

    // Store new link
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:ticket_services,id',
            'user_id' => 'required|exists:site_user,id',
        ]);

        TicketServiceUser::firstOrCreate([
            'service_id' => $request->service_id,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('admin.ticket_service_user.index')->with('success', 'User linked to service successfully.');
    }

    // Edit form
    public function edit($id)
    {
        $link = TicketServiceUser::findOrFail($id);
        $services = TicketService::where('is_active', true)->get();
        // $users = User::all();

        $siteUsers = SiteUser::all();
        return view('admin.ticket_service_user.edit', compact('link', 'services', 'siteUsers'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'service_id' => 'required|exists:ticket_services,id',
            'user_id' => 'required|exists:site_user,id',
        ]);

        $link = TicketServiceUser::findOrFail($id);
        $link->update([
            'service_id' => $request->service_id,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('admin.ticket_service_user.index')->with('success', 'Service-user link updated successfully.');
    }

    // Delete
    public function destroy($id)
    {
        TicketServiceUser::findOrFail($id)->delete();
        return redirect()->route('admin.ticket_service_user.index')->with('success', 'Link removed successfully.');
    }
}
