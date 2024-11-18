<?php

namespace App\Http\Controllers\GuestList;

use App\Http\Controllers\Controller;

class GuestListsController extends Controller
{
    public function downloadGuestListTemplate()
    {
        return response()->download('assets/files/guests_list_template.xlsx', 'EventsDon Guests List Template.xlsx');
    }

    public function index()
    {
    }
}
