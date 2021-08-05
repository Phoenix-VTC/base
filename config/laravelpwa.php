<?php

return [
    'name' => 'PhoenixBase',
    'manifest' => [
        'name' => 'PhoenixBase',
        'short_name' => 'PhoenixBase',
        'start_url' => '/',
        'background_color' => '#F4F5F7',
        'theme_color' => '#18181B',
        'display' => 'standalone',
        'orientation'=> 'any',
        'status_bar'=> 'black',
        'icons' => [
            '72x72' => [
                'path' => '/images/icons/icon-72x72.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => '/images/icons/icon-96x96.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => '/images/icons/icon-128x128.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => '/images/icons/icon-144x144.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => '/images/icons/icon-152x152.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => '/images/icons/icon-192x192.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => '/images/icons/icon-maskable.png',
                'purpose' => 'any maskable'
            ],
            '512x512' => [
                'path' => '/images/icons/icon-512x512.png',
                'purpose' => 'any'
            ],
        ],
        'shortcuts' => [
            [
                'name' => 'Submit job',
                'description' => 'Submit a new job',
                'url' => '/jobs/choose-game',
                'icons' => [
                    'src' => '/images/icons/plus-icon.png',
                    'purpose' => 'any'
                ]
            ]
        ],
        'custom' => []
    ]
];
