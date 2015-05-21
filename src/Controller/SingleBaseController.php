<?php namespace SmallTeam\Dashboard\Controller;

use \Illuminate\Routing\Router;

/**
 * SingleBaseController
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
class SingleBaseController extends DashboardController
{

    /**
     * @inheritdoc
     * */
    public static function routesMap(Router $router, $name, $controller, $parameters)
    {
        $router->get('/'.$name, $controller.'@getIndex');
        $router->post('/'.$name, $controller.'@save');
    }

    function getIndex()
    {
        return get_class($this).'::index';
    }

    function save()
    {
        return get_class($this).'::index';
    }

}