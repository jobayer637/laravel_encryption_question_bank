<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ModeratorDashboardController extends Controller
{
    public function index()
    {
        return view('moderator.dashboard');
    }
}
