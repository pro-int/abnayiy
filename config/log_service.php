<?php

return [
    'base_url' => env('LOG_BASE_URL','https://799rrpb9c5.execute-api.us-east-1.amazonaws.com'),
    'stage' => env('LOG_STAGE','dev'),
    'api_key' => env('LOG_API_KEY','G0GujKsnvy2TWI28vIBE77gEqKGu8aCP4a3hfPMA'),
    'create_path' => env('LOG_CREATE_PATH', '/create'),
    'search_path' => env('LOG_SEARCH_PATH', '/search'),
    'health_path' => env('LOG_STATUS_PATH', '/health'),
    'log_types' => [
        1 => 'Contract',
        2 => 'Transaction',
        3 => 'PaymentAttempt',
        4 => 'WithdrawalApplication',
        5 => 'Application'
    ],
];

