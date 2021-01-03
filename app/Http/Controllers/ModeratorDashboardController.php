<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModeratorDashboardController extends Controller
{
    public function index()
    {
        return view('moderator.dashboard');
    }
}
