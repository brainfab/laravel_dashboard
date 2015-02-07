<?php namespace SmallTeam\Dashboard\App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	public function boot()
	{
		$path_to_views = __DIR__.'/../../resources/views';
		$path_to_translations = __DIR__.'/../../resources/lang';

		include __DIR__.'/../Http/routes.php';
		$this->loadViewsFrom($path_to_views, 'dashboard');

		$this->publishes([
			$path_to_views => base_path('resources/views/vendor/dashboard'),
		]);

		$this->loadTranslationsFrom($path_to_translations, 'dashboard');

		$this->publishes([
			$path_to_translations => base_path('resources/lang'),
		]);

		$this->publishes([
			__DIR__.'/../../config/dashboard.php' => config_path('dashboard.php'),
		]);

		$this->publishes([
			__DIR__.'/../../public' => base_path('public/dashboard'),
		]);
	}

	public function register()
	{
		$this->mergeConfigFrom(
			__DIR__.'/../../config/dashboard.php', 'dashboard'
		);
	}

}