<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class ClientPlanController extends Controller
{
    public function index()
    {
        $plans = Plan::where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('price')
            ->get();

        return view('user.choose_plan', compact('plans'));
    }
}
