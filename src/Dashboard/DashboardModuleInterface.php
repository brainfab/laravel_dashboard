<?php namespace SmallTeam\Dashboard;

/**
 * DashboardModuleInterface
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
interface DashboardModuleInterface
{

    public function __construct(DashboardApp $app);

    /**
     * Init module routes
     *
     * @param \Illuminate\Routing\Router $router
     * @param string $module_name
     * @param string $module Module class name with namespace
     * @param string $prefix Dashboard prefix
     * @return void
     * */
    public static function routesMap(\Illuminate\Routing\Router $router, $module_name, $module, $prefix);

    /**
     * Get dashboard name
     *
     * @return string
     * */
    public function getDashboardName();

    /**
     * Get dashboard application
     *
     * @return \SmallTeam\Dashboard\DashboardApp
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