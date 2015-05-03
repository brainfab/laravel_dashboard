<?php namespace SmallTeam\Dashboard;

interface DashboardModuleInterface {

    /**
     * Init module routes
     *
     * @param \Illuminate\Routing\Router $router
     * @param string $module_name
     * @param string $module Module class name with namespace
     * @return void
     * */
    public static function routesMap(\Illuminate\Routing\Router $router, $module_name, $module);

    /**
     * Get module name
     *
     * @return string
     * */
    public function getModuleName();

}