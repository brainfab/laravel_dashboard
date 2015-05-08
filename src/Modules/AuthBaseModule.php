<?php namespace SmallTeam\Dashboard\Modules;

use Illuminate\Routing\Router;

/**
 * AuthBaseModule
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
class AuthBaseModule extends DashboardModule
{

    /**
     * @inheritdoc
     * */
    public static function routesMap(Router $router, $module_name, $module)
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