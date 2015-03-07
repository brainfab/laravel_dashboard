<?php namespace SmallTeam\Dashboard\App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	public function boot()
	{
		$path_to_views = __DIR__.'/../../resources/views';
		$path_to_translations = __DIR__.'/../../resources/lang';
		$langs = ['ru', 'en'];


		include __DIR__ . '/../Http/routes.php';
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
			__DIR__.'/../../config/modules.php' => config_path('modules.php'),
		]);
	}

	public function register()
	{
		if(isset($_SERVER['REQUEST_URI'])) {
			$prefix = config('dashboard.prefix');
			$uri = $_SERVER['REQUEST_URI'];
			$uri = substr($uri, strlen($uri)-1) == '/' ? $uri : $uri.'/';
			if( strpos($uri, '/'.$prefix.'/') === 0 || empty($prefix) || $prefix === '/') {
				app()->singleton(
					'Illuminate\Contracts\Debug\ExceptionHandler',
					'SmallTeam\Dashboard\App\Exceptions\Handler'
				);
			}
		}

		$this->mergeConfigFrom(
			__DIR__.'/../../config/dashboard.php', 'dashboard'
		);

		$this->mergeConfigFrom(
			__DIR__.'/../../config/modules.php', 'modules'
		);
	}

}