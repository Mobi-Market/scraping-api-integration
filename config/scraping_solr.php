<?php

declare(strict_types=1);

return [
    /*
     * API Details used for the internal client.
     */
    'api' => [
        'url'        => env('SCRAPING_SOLR_ENDPOINT'),
        'timeout'    => (float) env('SCRAPING_SOLR_TIMEOUT', 30.0),
        'should_log' => env('SCRAPING_SOLR_SHOULD_LOG', true),
    ],

    /*
     * Authentication details for the Scraping integration.
     */
    'auth' => [
        'username'   => env('SCRAPING_SOLR_USERNAME'),
        'password'   => env('SCRAPING_SOLR_PASSWORD'),
    ],
];
