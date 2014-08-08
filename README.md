Laravel Dashboard
=================

Install laravel framework

Add admin package to require in composer.json and run composer update:

"small-team/laravel-admin": "dev-master"

After updating composer, add the ServiceProvider to the providers array in app/config/app.php:

'SmallTeam\Admin\AdminServiceProvider',

Update class loader:

$ php artisan dump-autoload

Init admin dashboard:

$ php artisan admin:init

Run migrate:

$ php artisan migrate --package=small-team/laravel-admin


:)