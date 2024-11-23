<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    // 'paths' => ['*'],

    'allowed_methods' => ['*'],

    // 'allowed_origins' => ['*'],

    'allowed_origins' => explode(',', env('ACCESS_DOMAINS')),

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];