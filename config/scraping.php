<?php

declare(strict_types=1);

return [
    /*
     * API Details used for the internal client.
     */
    'api' => [
        'url'        => env('SCRAPING_API_URL', 'https://webautomation.io/api/refurbished/'),
        'timeout'    => (float) env('SCRAPING_API_TIMEOUT', 30.0),
        'should_log' => env('SCRAPING_API_SHOULD_LOG', true),
    ],

    /*
     * Authentication details for the Scraping integration.
     */
    'auth' => [
        'username'   => env('SCRAPING_AUTH_USERNAME'),
        'password'   => env('SCRAPING_AUTH_PASSWORD'),
    ],
];
