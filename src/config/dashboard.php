<?php
return [
    'locales' => ['ru', 'en'],

    'files' => [
        'image_engine' => 'imagick', //imagick or gd
        'imagick_path' => '', //path to imagick
        'upload_path' => 'upload', //upload files path
    ],

    'dashboards' => [
        'admin' => [
            'name' => 'My Admin Dashboard',
            'logo' => 'dashboard/logo.png',
            'prefix' => 'admin', //routes prefix, not required
            'domain' => null, //routes domain, not required
            'namespace' => null, //routes namespace, not required
            'default_locale' => 'en',
            'modules' => [
                '/' => 'SmallTeam\Dashboard\Modules\IndexBaseModule',
//                'posts' => 'App\Dashboard\Modules\PostsModule',
            ]
        ],
    ],
];