<?php namespace SmallTeam\Dashboard\Controller;

use SmallTeam\Dashboard\Dashboard;
use Illuminate\Routing\Router;

/**
 * DashboardControllerInterface
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
interface DashboardControllerInterface
{

    public function __construct(Dashboard $app);

    /**
     * Init controller routes
     *
     * @param Router $router
     * @param string $name
     * @param string $controller Controller class name with namespace
     * @param string $parameters
     * @return void
     * */
    public static function routesMap(Router $router, $name, $controller, $parameters);

    /**
     * Get dashboard name
     *
     * @return string
     * */
    public function getDashboardName();

    /**
     * Get dashboard application
     *
     * @return \SmallTeam\Dashboard\Dashboard
     * */
    public function getDashboard();

    /**
     * Get dashboard config
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     * */
    public function getDashboardConfig($key = null, $default = null);

    /**
     * Get auth middleware name
     *
     * @return string
     * */
    public function getAuthMiddleware();

    /**
     * Get guest middleware name
     *
     * @return string
     * */
    public function getGuestMiddleware();

    /**
     * Get menu factory
     *
     * @return null
     * */
    public function getMenuFactory();

    /**
     * Get menu
     *
     * @return null
     * */
    public function getMenu();

}