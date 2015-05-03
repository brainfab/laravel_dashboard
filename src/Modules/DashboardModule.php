<?php namespace SmallTeam\Dashboard\Modules;

use Illuminate\Routing\Controller as BaseController;
use \SmallTeam\Dashboard\DashboardModuleInterface;

abstract class DashboardModule extends BaseController implements DashboardModuleInterface
{
    /** @property string $module_name */
    protected $module_name = null;

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
        //define routes
    }

	public function missingMethod($arr = [])
    {
		return view('dashboard::errors.404');
	}

    public function getModuleName()
    {
        return $this->module_name;
    }

}