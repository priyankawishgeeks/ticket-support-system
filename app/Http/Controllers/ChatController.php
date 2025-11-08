<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
  public function store(Request $request)
{
    // handle and store the incoming chat message
    return response()->json(['success' => true]);
}
}
