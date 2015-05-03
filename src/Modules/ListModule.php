<?php namespace SmallTeam\Dashboard\Modules;

class ListModule extends DashboardModule
{

    use \SmallTeam\Dashboard\GuardedModuleTrait;

    /**
     * Init module routes
     *
     * @param \Illuminate\Routing\Router $router
     * @param string $module_name
     * @param string $module Module class name with namespace
     * @return void
     * */
    public static function routesMap(\Illuminate\Routing\Router $router, $module_name, $module)
    {
        $router->get('/'.$module_name, $module.'@index');
        $router->get('/'.$module_name.'/page/{page_number}', $module.'@index')->where('page_number', '[0-9]+');

        $router->get('/'.$module_name.'/add', $module.'@getAdd');
        $router->post('/'.$module_name.'/add', $module.'@postAdd');

        $router->get('/'.$module_name.'/edit/{id}', $module.'@getEdit')->where('page_number', '[0-9]+');
        $router->post('/'.$module_name.'/edit/{id}', $module.'@postEdit')->where('page_number', '[0-9]+');

        $router->get('/'.$module_name.'/delete/{id}', $module.'@index')->where('page_number', '[0-9]+');
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