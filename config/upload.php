<?php

return [
    'default_folder_path' => 'images/default/',
    'image_upload' => [
        'auth' => [
            'api_key' => env('UPLOAD_API_KEY'),
            'api_secret' => env('UPLOAD_API_SECRET'),
            'oauth_token' => env('UPLOAD_OAUTH_TOKEN'),
            'oauth_token_secret' => env('UPLOAD_OAUTH_TOKEN_SECRET'),
        ],
        'host' => env('UPLOAD_HOST'),
        'rest_link' => 'https://api.flickr.com/services/rest/',
        'max_size' => 3456789,
        'max_with' => 320,
        'max_with_array' => [100, 240, 320, 500, 640, 1024],
    ],
];
