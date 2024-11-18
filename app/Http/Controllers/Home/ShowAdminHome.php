<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

//use Inertia\Inertia;

class ShowAdminHome extends Controller
{
    public function __invoke()
    {
        //return Inertia::render('Home/Admin');
        $data['page_title'] = 'Dashboard';

        return view('admin.home.dashboard', $data);
    }
}
