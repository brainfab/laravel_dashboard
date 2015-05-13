<?php namespace SmallTeam\Dashboard\App\Providers;

use Illuminate\Support\ServiceProvider;
use \SmallTeam\Dashboard\RoutesMap;
use \SmallTeam\Dashboard\DashboardApp;

class AppServiceProvider extends ServiceProvider
{

	public function boot()
	{
		$path_to_assets = __DIR__.'/../resources/views';
		$path_to_views = __DIR__.'/../resources/views';
		$path_to_translations = __DIR__.'/../resources/lang';

		$locales = config('dashboard.locales');

		$this->loadViewsFrom($path_to_views, 'dashboard');

		$this->publishes([
			$path_to_views => base_path('resources/views/vendor/dashboard'),
		]);

		$this->loadTranslationsFrom($path_to_translations, 'dashboard');

        if(is_array($locales) && count($locales) > 0)
        {
            foreach ($locales as $locale) {
                $this->publishes([
                    $path_to_translations.'/'.$locale => base_path('resources/lang/packages/'.$locale.'/laravel-dashboard'),
                ]);
            }
        }

		$this->publishes([
			__DIR__.'/../../config/dashboard.php' => config_path('dashboard.php'),
		]);

        $this->publishes([
            $path_to_assets => public_path('vendor/dashboard'),
        ], 'public');

        /** Register dashboard middlewares */
        $router = $this->app['router'];
        $router->middleware('dashboard.auth', 'SmallTeam\Dashboard\Middleware\Authenticate');
        $router->middleware('dashboard.guest', 'SmallTeam\Dashboard\Middleware\Guest');

        /** Register dashboard routes */
        $dashboards = config('dashboard.dashboards');
        if(is_array($dashboards) && count($dashboards) > 0) {
            foreach ($dashboards as $dashboard) {
                $modules = isset($dashboard['modules']) && is_array($dashboard['modules']) && count($dashboard['modules']) > 0
                    ? $dashboard['modules']
                    : [];

                $modules['__auth'] = 'SmallTeam\Dashboard\Modules\Auth\AuthBaseModule';
                $modules['__password'] = 'SmallTeam\Dashboard\Modules\Auth\PasswordBaseModule';

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