<?php

return [
    'base_url' => env('OKTA_BASE_URL', 'https://dev-123456.okta.com'),
    'client_id' => env('OKTA_CLIENT_ID'),
    'client_secret' => env('OKTA_CLIENT_SECRET'),
    'redirect_uri' => env('OKTA_REDIRECT_URI'),
    'scopes' => env('OKTA_SCOPES', 'openid profile email'),
];
