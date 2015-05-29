<?php namespace SmallTeam\Dashboard\Controller;

use SmallTeam\Dashboard\Dashboard;
use SmallTeam\Dashboard\Routing\Router;

/**
 * DashboardControllerInterface
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
interface DashboardControllerInterface
{

    public function __construct(Dashboard $dashboard);

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

}