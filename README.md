Laravel Dashboard
=================

Install laravel framework

Add admin package to require in composer.json and run composer update:

<pre>"small-team/laravel-admin": "dev-master"</pre>

After updating composer, add the ServiceProvider to the providers array in app/config/app.php:

<pre>'SmallTeam\Admin\AdminServiceProvider',</pre>

Update class loader:

<pre>$ php artisan dump-autoload</pre>

Init admin dashboard:

<pre>$ php artisan admin:init</pre>
