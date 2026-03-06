<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Trip.com API Configuration
    |--------------------------------------------------------------------------
    |
    | Configure your Trip.com API credentials and settings here.
    | Apply for API access at: https://www.trip.com/openplatform/
    |
    */

    'base_url' => env('TRIPCOM_API_BASE_URL', 'https://api.trip.com/openapi'),
    'api_key' => env('TRIPCOM_API_KEY', ''),
    'api_secret' => env('TRIPCOM_API_SECRET', ''),
    'use_mock' => env('TRIPCOM_USE_MOCK', true),
    'timeout' => env('TRIPCOM_TIMEOUT', 30),
    'currency' => env('TRIPCOM_CURRENCY', 'USD'),
    'language' => env('TRIPCOM_LANGUAGE', 'en'),
];
