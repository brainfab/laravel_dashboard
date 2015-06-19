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
            'name' => 'Admin Dashboard',
            'short_name' => 'AD',
            'prefix' => 'admin', //routes prefix, not required
            'domain' => null, //routes domain, not required
            'namespace' => null, //routes namespace, not required
            'default_locale' => 'en',

            'security' => [
                'auth' => [
                    'enabled' => false,
                    'handler' => 'SmallTeam\Dashboard\Security\LaravelAuthHandler',
                    'auth_entity' => 'SmallTeam\Dashboard\Entity\AuthEntity',
                    'password_entity' => 'SmallTeam\Dashboard\Entity\PasswordEntity',
                ],
                'acl' => [
                    'enabled' => false,
                    'handler' => 'SmallTeam\Dashboard\Security\NativeAclHandler'
                ]
            ],
            'entities' => [
//                'posts' => 'App\Admin\Entity\Post',
            ]
        ],
    ],
];