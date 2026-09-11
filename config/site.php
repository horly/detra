<?php

return [
    'name' => 'DETRA SARL',
    'city' => 'Kinshasa',
    'email' => env('DETRA_EMAIL', 'sales@detradrc.com'),
    'phone' => env('DETRA_PHONE', '(+243) 999 964 546'),
    'address' => env('DETRA_ADDRESS', '25c, Dr MANKOYI, Kinshasa – Ngaliema / R.D. Congo'),
    'website' => env('DETRA_WEBSITE', 'https://www.detradrc.com'),
    'pages' => [
        'fr' => [
            'home' => '/', 'about' => 'a-propos', 'services' => 'services',
            'products' => 'produits', 'commitments' => 'engagements',
            'contact' => 'contact', 'privacy' => 'confidentialite',
        ],
        'en' => [
            'home' => '/', 'about' => 'about', 'services' => 'services',
            'products' => 'products', 'commitments' => 'commitments',
            'contact' => 'contact', 'privacy' => 'privacy',
        ],
    ],
];
