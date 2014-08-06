<?php namespace Vendor\Admin;

use Illuminate\Support\ServiceProvider;
use \Illuminate\Support\ClassLoader;
use \Illuminate\Support\Facades\Artisan;

class AdminServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('vendor/admin');
        include __DIR__.'/../../routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        //admin:gen_controller
        $this->app['admin:gen_controller'] = $this->app->share(function($app)
        {
            return new AdminGenController();
        });
        $this->commands('admin:gen_controller');

        //admin:init
        $this->app['admin:init'] = $this->app->share(function($app)
        {
            return new AdminInit();
        });
        $this->commands('admin:init');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array(
            'admin:gen_controller',
            'admin:init',
        );
	}

}
