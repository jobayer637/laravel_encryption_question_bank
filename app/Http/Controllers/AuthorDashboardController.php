<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorDashboardController extends Controller
{
    public function index(){
        return view('author.dashboard');
    }
}
