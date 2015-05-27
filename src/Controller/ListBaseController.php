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

        $router->get('/'.$name.'/edit/{id}', 'getEdit')->where('page_number', '[0-9]+');
        $router->post('/'.$name.'/edit/{id}', 'postEdit')->where('page_number', '[0-9]+');

        $router->get('/'.$name.'/delete/{id}', 'index')->where('page_number', '[0-9]+');
    }

    public function index()
    {
        return get_class($this).'::anyIndex';
    }

    public function getAdd()
    {
        return get_class($this).'::anyAdd';
    }

    public function postAdd()
    {
        return get_class($this).'::anyAdd';
    }

    public function getEdit($id = null)
    {
        $id = intval($id);
        if($id <= 0) {
            abort(404);
        }

        return get_class($this).'::anyEdit';
    }

    public function postEdit($id = null)
    {
        $id = intval($id);
        if($id <= 0) {
            abort(404);
        }

        return get_class($this).'::anyEdit';
    }

    public function delete($id = null)
    {
        return get_class($this).'::anyDelete';
    }

}