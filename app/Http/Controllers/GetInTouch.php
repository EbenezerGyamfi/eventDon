<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerInquiryRequest;
use App\Notifications\CustomerInquiryNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class GetInTouch extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CustomerInquiryRequest $request)
    {
        Notification::route('mail', 'support@arkesel.com')
            ->notify(new CustomerInquiryNotification($request->validated()));

        return $request->wantsJson()
            ? response()->noContent()
            : redirect()->back();
    }
}
