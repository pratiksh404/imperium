<?php

return [
    'author' => 'Pratik Shrestha',
    'debug' => env('APP_DEBUG', true),

    'name' => env('APP_NAME', 'Imperium'),

    'media' => [
        'image' => [
            'logo' => [
                'dark' => 'imperium/assets/img/app/logo-dark.png',
                'light' => 'imperium/assets/img/app/logo-light.png',
                'small' => 'imperium/assets/img/app/logo-sm.png',
            ],
            'favicon' => 'imperium/assets/img/app/favicon.ico',
            'auth' => [
                'background' => 'imperium/assets/img/app/bg.jpg',
            ],
        ],
    ],
];
