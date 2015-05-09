<?php namespace SmallTeam\Dashboard\Modules;

use Illuminate\Routing\Router;

/**
 * IndexBaseModule
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
class IndexBaseModule extends DashboardModule
{

    /**
     * @inheritdoc
     * */
    public static function routesMap(Router $router, $module_name, $module, $prefix)
    {
        $router->get('/', $module.'@index');
    }

	public function index()
	{
        dd($this->getDashboardConfig());
		return $this->getDashboardName();
	}

}