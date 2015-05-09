<?php namespace SmallTeam\Dashboard\App\Providers;

use Illuminate\Support\ServiceProvider;
use \SmallTeam\Dashboard\RoutesMap;
use \SmallTeam\Dashboard\DashboardApp;

class AppServiceProvider extends ServiceProvider
{

	public function boot()
	{
		$path_to_views = __DIR__.'/../resources/views';
		$path_to_translations = __DIR__.'/../resources/lang';
		$langs = ['ru', 'en'];

		$this->loadViewsFrom($path_to_views, 'dashboard');

		$this->publishes([
			$path_to_views => base_path('resources/views/vendor/dashboard'),
		]);

		$this->loadTranslationsFrom($path_to_translations, 'dashboard');

		foreach ($langs as $lang) {
			$this->publishes([
				$path_to_translations.'/'.$lang => base_path('resources/lang/packages/'.$lang.'/laravel-dashboard'),
			]);
		}

		$this->publishes([
			__DIR__.'/../../config/dashboard.php' => config_path('dashboard.php'),
		]);

        /** Register dashboard middlewares */
        $router = $this->app['router'];
        $router->middleware('dashboard.auth', 'SmallTeam\Dashboard\Middleware\Authenticate');

        /** Register dashboard routes */
        $dashboards = config('dashboard.dashboards');
        if(is_array($dashboards) && count($dashboards) > 0) {
            foreach ($dashboards as $dashboard) {
                $modules = isset($dashboard['modules']) && is_array($dashboard['modules']) && count($dashboard['modules']) > 0
                    ? $dashboard['modules']
                    : [];

                if(isset($dashboard['auth']['module'])) {
                    $modules['__auth'] = $dashboard['auth']['module'];
                }

                $namespace = isset($dashboard['namespace']) && !empty($dashboard['namespace']) ? $dashboard['namespace'] : null;
                $prefix = isset($dashboard['prefix']) && !empty($dashboard['prefix']) ? $dashboard['prefix'] : null;
                $domain = isset($dashboard['domain']) && !empty($dashboard['domain']) ? $dashboard['domain'] : null;

                if(is_array($modules) && count($modules) > 0) {
                    $builder = new RoutesMap( $modules, $prefix, $namespace, $domain );
                    \Route::group(['namespace' => $namespace, 'prefix' => $prefix, 'domain' => $domain], $builder->map());
                }
            }
        }
	}

	public function register()
	{
        $this->app->singleton('SmallTeam\Dashboard\DashboardApp', function() {
            return new DashboardApp();
        });

		$this->mergeConfigFrom(
			__DIR__.'/../config/dashboard.php', 'dashboard'
		);
	}

}