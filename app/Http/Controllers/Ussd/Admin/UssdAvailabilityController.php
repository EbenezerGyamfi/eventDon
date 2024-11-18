<?php

namespace App\Http\Controllers\Ussd\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UssdExtension\CheckUssdRequest;

class UssdAvailabilityController extends Controller
{
    public function store(CheckUssdRequest $request)
    {
        return back()->with('message', 'USSD code is available');
    }
}
