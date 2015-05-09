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

    /** @var bool */
    protected $guarded_module = false;

    /**
     * @inheritdoc
     * */
    public static function routesMap(Router $router, $module_name, $module, $prefix)
    {
        $router->get('/login', ['as' => 'Dashboard.'.$prefix.'.getLogin', 'uses' => $module.'@getLogin']);
        $router->post('/login', ['as' => 'Dashboard.'.$prefix.'.postLogin', 'uses' => $module.'@postLogin']);
        $router->get('/logout', ['as' => 'Dashboard.'.$prefix.'.getLogout', 'uses' => $module.'@getLogout']);
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