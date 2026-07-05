<?php

return [
    'provider' => env('WA_PROVIDER', 'wa_ai'),

    // Queue used for outbound WhatsApp jobs.
    'queue' => env('WA_QUEUE', 'default'),

    // Febrian WA AI provider. When base_url/api_key are empty the client runs
    // in SIMULATED mode — messages are still queued and logged, but no HTTP
    // call is made (handy for local/demo). Adjust send_path to the real API.
    'wa_ai' => [
        'base_url' => env('WA_AI_BASE_URL'),
        'api_key' => env('WA_AI_API_KEY'),
        'send_path' => env('WA_AI_SEND_PATH', '/api/send'),
        'timeout' => (int) env('WA_AI_TIMEOUT', 15),
    ],

    'otp' => [
        'template' => 'Kode OTP Anda adalah *{{code}}*. Berlaku {{ttl}} menit. Jangan bagikan kode ini kepada siapa pun.',
        'ttl' => (int) env('WA_OTP_TTL', 5),
    ],
];
