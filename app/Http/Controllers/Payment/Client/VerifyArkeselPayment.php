<?php

namespace App\Http\Controllers\Payment\Client;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessArkeselPayment;
use Illuminate\Http\Request;

class VerifyArkeselPayment extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        ProcessArkeselPayment::dispatch($request->all());

        return response()->noContent();
    }
}
