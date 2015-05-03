<?php
return [
    'files' => [
        'image_engine' => 'imagick', //imagick or gd
        'imagick_path' => '', //path to imagick
        'upload_path' => 'upload', //upload files path
    ],

    'dashboards' => [
        'admin' => [
            'prefix' => 'admin', //routes prefix, not required
            'domain' => null, //routes domain, not required
            'namespace' => null, //routes namespace, not required
            'default_lang' => 'en',
            'auth' => [
                'model' => 'App\User',
                'table' => 'users',
                'fields' => [
                    'password' => 'password',
                    'login' => null,
                    'email' => 'email',
                ]
            ],
            'index_module' => 'SmallTeam\Dashboard\Modules\IndexModule',
            'auth_module' => 'SmallTeam\Dashboard\Modules\AuthModule',
            'modules' => [
//                'posts' => 'App\Dashboard\Modules\PostsModule',
//                'App\Dashboard\Modules\UsersModule',
            ]
        ],
    ],
];