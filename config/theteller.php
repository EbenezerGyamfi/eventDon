<?php

return [

    /*
    |--------------------------------------------------------------------------
    | TheTeller API Config
    |--------------------------------------------------------------------------
    |
    */

    'apiUrl' => env('THETELLER_API_URL'),

    'apiKey' => env('THETELLER_API_KEY'),

    'username' => env('THETELLER_USERNAME'),

    'merchantId' => env('THETELLER_MERCHANT_ID'),

    'codes' => [
        'momoPayment' => '000200',

    ],

];
