<?php namespace SmallTeam\Dashboard\Controller;

use SmallTeam\Dashboard\Routing\Router;

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
        $router->get('/'.$name, 'getIndex');
        $router->post('/'.$name, 'save');
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