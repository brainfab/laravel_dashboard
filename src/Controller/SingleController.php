<?php namespace SmallTeam\Dashboard\Controller;

use SmallTeam\Dashboard\Routing\Router;

/**
 * SingleController
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
class SingleController extends Controller
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
        return __METHOD__;
    }

    function save()
    {
        return __METHOD__;
    }

}