<?php

namespace App\Http\Controllers;

class ContactPageController extends Controller
{
    //
    public function __invoke()
    {
        return view('pages.contact-page');
    }
}
