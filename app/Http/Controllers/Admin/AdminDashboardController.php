<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\User;
use App\Subject;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $users = User::where('role_id', '!=', 1)->get();
        $subjects = Subject::where('status', 1)->get();
        return view('admin.dashboard', compact('users', 'subjects'));
    }
}
