<?php namespace SmallTeam\Dashboard\Modules;

use Illuminate\Routing\Router;

class IndexModule extends DashboardModule
{

    use \SmallTeam\Dashboard\GuardedModuleTrait;

    /**
     * Init module routes
     *
     * @param \Illuminate\Routing\Router $router
     * @param string $module_name
     * @param string $module Module class name with namespace
     * @return void
     * */
    public static function routesMap(\Illuminate\Routing\Router $router, $module_name, $module)
    {
        $router->get('/', $module.'@index');
    }

	public function index()
	{
		return get_class($this).'::index';
	}

}