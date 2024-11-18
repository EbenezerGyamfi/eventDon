<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Arkesel API key
    |--------------------------------------------------------------------------
    |
    | This is the API key used to authenticate with the Arkesel Cloud Communications API.
    |
    */

    'apiKey' => env('ARKESEL_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Arkesel Payment Configuration
    |--------------------------------------------------------------------------
    |
    */

    'payment' => [

        'apiKey' => env('ARKESEL_PAYMENT_API_KEY', ''),

        'apiUrl' => env('ARKESEL_PAYMENT_API_URL', ''),

        'serviceName' => env('APP_NAME'),

    ],

    /*
    |--------------------------------------------------------------------------
    | Arkesel API URL
    |--------------------------------------------------------------------------
    |
    | This is the API URL used to connect to the Arkesel Cloud Communications API.
    |
    */

    'apiUrl' => env('ARKESEL_API_URL', ''),

    'sandbox' => (bool) env('ARKESEL_SANDBOX_MODE'),

    'telescopeEmails' => env('ARKESEL_TELESCOPE_EMAILS'),

    'telescopeSecurity' => (bool) env('ARKESEL_TELESCOPE_SECURITY'),

];
