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
                    'handler' => SmallTeam\Dashboard\Security\LaravelAuthHandler::class,
                    'auth_controller' => SmallTeam\Dashboard\Controller\Auth\AuthController::class,
                    'password_controller' => SmallTeam\Dashboard\Controller\Auth\PasswordController::class,
                ],
                'acl' => [
                    'enabled' => false,
                    'handler' => SmallTeam\Dashboard\Security\NativeAclHandler::class
                ]
            ],

            'base_list_controller' => SmallTeam\Dashboard\Controller\ListController::class,
            'base_single_controller' => SmallTeam\Dashboard\Controller\SingleController::class,
            'base_dashboard_controller' => SmallTeam\Dashboard\Controller\DashboardController::class,

            'entities' => [
//                'users' => App\Admin\Entity\UserEntity::class,
            ]
        ],
    ],
];