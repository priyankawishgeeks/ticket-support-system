<?php

namespace App\Http\Controllers\Superviser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperviserController extends Controller
{
    public function index(){
        return view('superviser.dashboard');
    }
}
