<?php namespace SmallTeam\Dashboard\Controller;

use SmallTeam\Dashboard\Routing\Router;

/**
 * IndexController
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
class IndexController extends DashboardController
{

    /**
     * @inheritdoc
     * */
    public static function routesMap(Router $router, $name, $controller, $parameters)
    {
        $router->get('/', 'index');
    }

	public function index()
	{
        return view('dashboard::index');
	}

}