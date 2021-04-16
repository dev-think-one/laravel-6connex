<?php

return [
    'client_domain' => env('SIXCONNEX_DOMAIN', 'dentistry'),
    'api_username'  => env('SIXCONNEX_API_USERNAME'),
    'api_password'  => env('SIXCONNEX_API_PASSWORD'),
    'options'       => [
        'top_level_domain'     => env('SIXCONNEX_TOP_DOMAIN', 'eu'),
        'ssl'                  => true,
        'production'           => (bool) env('SIXCONNEX_PRODUCTION', 1),
    ],
];
