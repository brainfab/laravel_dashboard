<?php namespace SmallTeam\Dashboard\App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	public function boot()
	{
		$path_to_views = __DIR__.'/../../resources/views';
		$path_to_translations = __DIR__.'/../../resources/lang';
		$langs = ['ru', 'en'];


		include __DIR__.'/../Http/routes.php';
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
			__DIR__.'/../../config/dashboard_modules.php' => config_path('dashboard_modules.php'),
		]);
	}

	public function register()
	{
		$this->mergeConfigFrom(
			__DIR__.'/../../config/dashboard.php', 'dashboard'
		);

		$this->mergeConfigFrom(
			__DIR__.'/../../config/dashboard_modules.php', 'dashboard_modules'
		);
	}

}