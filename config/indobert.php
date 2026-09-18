<?php

return [
    'url' => env('INDOBERT_API_URL', 'http://127.0.0.1:5001'),
    'timeout' => (int) env('INDOBERT_TIMEOUT', 30),
    'token' => env('INDOBERT_TOKEN'),
];
