<?php namespace SmallTeam\Dashboard\App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
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
			__DIR__.'/../../config/dashboard.php' => config_path('dashboard.php'),
		]);
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom(
			__DIR__.'/../../config/dashboard.php', 'dashboard'
		);
	}

}