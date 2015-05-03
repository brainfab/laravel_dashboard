<?php namespace SmallTeam\Dashboard\Modules;

use Illuminate\Routing\Router;

class AuthModule extends DashboardModule
{

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
        $router->get('/login', $module.'@getLogin');
        $router->post('/login', $module.'@postLogin');
        $router->get('/logout', $module.'@getLogout');
    }

	public function getLogin()
	{
		return get_class($this).'::login';
	}

	public function postLogin()
	{
		return get_class($this).'::login';
	}

	public function getLogout()
	{
		return get_class($this).'::logout';
	}

}