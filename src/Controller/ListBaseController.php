<?php namespace SmallTeam\Dashboard\Controller;

use SmallTeam\Dashboard\Routing\Router;

/**
 * ListBaseController
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
class ListBaseController extends DashboardController
{

    /** @var string */
    protected $model;

    /**
     * @inheritdoc
     * */
    public static function routesMap(Router $router, $name, $controller, $parameters)
    {
        $router->get('/'.$name, 'index');
        $router->get('/'.$name.'/page/{page_number}', 'index')->where('page_number', '[0-9]+');

        $router->get('/'.$name.'/add', 'getAdd');
        $router->post('/'.$name.'/add', 'postAdd');

        $router->get('/'.$name.'/{id}/edit', 'getEdit')->where('id', '[0-9]+');
        $router->post('/'.$name.'/{id}/edit', 'postEdit')->where('id', '[0-9]+');

        $router->get('/'.$name.'/{id}/show', 'getShow')->where('id', '[0-9]+');

        $router->get('/'.$name.'/{id}/delete', 'delete')->where('id', '[0-9]+');
    }

    public function index()
    {
        return __METHOD__;
    }

    public function getAdd()
    {
        return __METHOD__;
    }

    public function postAdd()
    {
        return __METHOD__;
    }

    public function getEdit($id = null)
    {
        $id = intval($id);
        if($id <= 0) {
            abort(404);
        }

        return __METHOD__;
    }

    public function getShow($id = null)
    {
        $id = intval($id);
        if($id <= 0) {
            abort(404);
        }

        return __METHOD__;
    }

    public function postEdit($id = null)
    {
        $id = intval($id);
        if($id <= 0) {
            abort(404);
        }

        return __METHOD__;
    }

    public function delete($id = null)
    {
        return __METHOD__;
    }

}