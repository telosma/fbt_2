<?php

return [
    'image_upload' => [
        'auth' => [
            'api_key' => env('UPLOAD_API_KEY'),
            'api_secret' => env('UPLOAD_API_SECRET'),
            'oauth_token' => env('UPLOAD_OAUTH_TOKEN'),
            'oauth_token_secret' => env('UPLOAD_OAUTH_TOKEN_SECRET'),
        ],
        'host' => env('UPLOAD_HOST'),
    ],
];
