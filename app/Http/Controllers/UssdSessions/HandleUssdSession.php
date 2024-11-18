<?php

namespace App\Http\Controllers\UssdSessions;

use App\Http\Controllers\Controller;
use App\Support\Ussd\UssdSessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HandleUssdSession extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, UssdSessionService $ussdSessionService)
    {
        $requestBody = $request->all();

        try {
            $response = $ussdSessionService->handleUssdSession($requestBody);

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'sessionID' => $requestBody['sessionID'],
                'userID' => $requestBody['userID'],
                'msisdn' => $requestBody['msisdn'],
                'message' => 'An error occurred',
                'continueSession' => false,
            ]);
        }
    }
}
