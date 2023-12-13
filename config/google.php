<?php
return [
    'web' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect_uris' => [env('GOOGLE_REDIRECT_URI')],
        'access_type' => 'offline',
        'prompt' => 'consent',
        'include_granted_scopes' => true,
    ],
];
