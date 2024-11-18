<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ShowClientHome extends Controller
{
    public function __invoke()
    {
        // return Inertia::render('Home/Client');
        return view('client.home.dashboard', ['page_title' => 'Dashboard']);
    }
}
