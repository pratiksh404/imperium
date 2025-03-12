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

    'schema' => [
        'rules' => [
            'tinyint' => [
                'configurations' => [
                    'boolean' => true
                ],
                'default' => ['boolean']
            ],
            'char' => [
                'default' => ['min:0']
            ],
            'text' => [
                'default' => ['min:0']
            ],
            'int' => [
                'default' => []
            ],
            'unsigned' => [
                'default' => []
            ],
            'double' => [
                'default' => ['numeric']
            ],
            'decimal' => [
                'default' => ['numeric']
            ],
            'dec' => [
                'default' => ['numeric']
            ],
            'float' => [
                'default' => ['numeric']
            ],
            'enum' => [
                'default' => ['numeric']
            ],
            'set' => [
                'default' => ['numeric']
            ],
            'year' => [
                'default' => ['integer', 'min:1901', 'max:2155']
            ],
            'date' => [
                'default' => ['numeric']
            ],
            'time' => [
                'default' => ['numeric']
            ],
            'timestamp' => [
                'default' => ['date', 'after_or_equal:1970-01-01 00:00:01', 'before_or_equal:2038-01-19 03:14:07']
            ],
            'json' => [
                'default' => 'json'
            ]
        ]
    ]
];
