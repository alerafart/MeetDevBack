<?php

return [
    'defaults' => [
        'guard' => 'api',
        'passwords' => 'users',
    ],

    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
    ],

    'providers' => [

        'users' => [
            'driver' => 'eloquent',
            'model' => \App\Models\User::class,
            Tymon\JWTAuth\Providers\LaravelServiceProvider::class
        ]
    ]
];
