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
            'prefix' => 'admin', //routes prefix, not required
            'domain' => null, //routes domain, not required
            'namespace' => null, //routes namespace, not required
            'default_locale' => 'en',

            'security' => [
                'auth' => [
                    'handler' => 'SmallTeam\Dashboard\Security\LaravelAuthHandler',
                    'auth_entity' => 'SmallTeam\Dashboard\Entity\AuthBaseEntity',
                    'password_entity' => 'SmallTeam\Dashboard\Entity\PasswordBaseEntity',
                ],
                'acl' => [
                    'handler' => 'SmallTeam\Dashboard\Security\NativeAclHandler'
                ]
            ],

            'default_entity' => 'SmallTeam\Dashboard\Entity\IndexBaseEntity',
            'entities' => [
//                'posts' => 'App\Admin\Entity\Post',
            ]
        ],
    ],
];