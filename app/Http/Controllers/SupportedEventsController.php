<?php

namespace App\Http\Controllers;

class SupportedEventsController extends Controller
{
    //
    public function __invoke()
    {
        return view('pages.supported-events-page');
    }
}
