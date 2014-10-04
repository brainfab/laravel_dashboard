<?php namespace SmallTeam\Admin;

use Illuminate\Support\ServiceProvider;
use \Illuminate\Support\ClassLoader;
use \Illuminate\Support\Facades\Artisan;
use \Illuminate\Support\Facades\File;

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
        if(isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/admin')!==0) {
            return;
        }
        if(is_dir(app_path().'/admin/modules')) {
            $directories = File::directories(app_path().'/admin/modules');

            if(is_array($directories) && !empty($directories)) {
                ClassLoader::addDirectories($directories);
                foreach ($directories as $dir) {
                    $files = File::files($dir);
                    if(is_array($files) && !empty($files)) {
                        foreach ($files as $file) {
                            if(strpos($file, '.php')===false)
                                continue;

                            $file = str_replace(array($dir, '/', '.php'), '', $file);
                            ClassLoader::load($file);
                        }
                    }
                }
            }
        }


        $this->package('small-team/admin');
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
