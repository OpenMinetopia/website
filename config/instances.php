<?php

return [
    'server_ip' => env('INSTANCE_IP', '127.0.0.1'),
    'pricing' => [
        '1_month' => 7.50,
        '3_months' => 21.00,
        '6_months' => 40.50,
        '12_months' => 75.00,
    ],
    'payment_methods' => [
        'bank_transfer' => [
            'account' => env('BANK_ACCOUNT', 'GIRO555'),
            'name' => env('ACCOUNT_NAME', 'John Deer'),
        ],
        'paypal' => [
            'email' => env('PAYPAL_EMAIL', 'peepeepeepee@gmail.com'),
        ]
    ]
];
