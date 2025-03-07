<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'mandrill' => [
        'secret' => env('MANDRILL_KEY'),
    ],

    'captcha' => [
        'site_key' => env('CAPTCHA_SITE_KEY'),
        'secret' => env('CAPTCHA_SECRET_KEY'),
    ],

    'hubtel' => [
        'api_id' => env('HUBTEL_API_ID'),
        'key' => env('HUBTEL_API_kEY'),
        'sales_number' => env('HUBTEL_SALES_NUMBER'),
    ],

];
