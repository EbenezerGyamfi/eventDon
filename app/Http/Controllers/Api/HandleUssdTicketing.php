<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\Ussd\UssdTicketingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HandleUssdTicketing extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, UssdTicketingService $ussdSessionService)
    {
        $requestBody = $request->all();

        try {
            $response = $ussdSessionService->handleUssdSession($requestBody);

            return response()->json($response);
        } catch (\Exception $e) {
            report($e);
            Log::info('USSD Ticketing');
            Log::error($e);

            return response()->json([
                'sessionID' => $requestBody['sessionID'],
                'userID' => $requestBody['userID'],
                'msisdn' => $requestBody['msisdn'],
                'message' => 'An issue occurred!',
                'continueSession' => false,
            ]);
        }
    }
}
