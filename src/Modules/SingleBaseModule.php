<?php namespace SmallTeam\Dashboard\Modules;

use \Illuminate\Routing\Router;

/**
 * SingleBaseModule
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
class SingleBaseModule extends DashboardModule
{

    /**
     * @inheritdoc
     * */
    public static function routesMap(Router $router, $module_name, $module, $prefix)
    {
        $router->get('/'.$module_name, $module.'@getIndex');
        $router->post('/'.$module_name, $module.'@save');
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