<?php

return [
    'payment' => [
        'url' => env('EBITS_PAYMENT_URL', ''),
        'username' => env('EBITS_PAYMENT_CLIENT_ID', ''),
        'password' => env('EBITS_PAYMENT_CLIENT_SECRET', ''),
    ],
];
