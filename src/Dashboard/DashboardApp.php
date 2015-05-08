<?php namespace SmallTeam\Dashboard;

use \Illuminate\Routing\Router;

/**
 * DashboardApp
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
class DashboardApp implements DashboardAppInterface
{
    /** @var bool */
    private $booted = false;

    /** @var string */
    private $dashboard_name = null;

    final public function __construct()
    {
        $this->boot();
    }

    /**
     * @inheritdoc
     * */
    public function boot()
    {
        if($this->booted) {
            return;
        }

        /** @var Router $router */
        $router = app()->router;
        $current = $router->current();
        $action = $current->getAction();

        $dashboards = config('dashboard.dashboards');
        foreach ($dashboards as $name => $dashboard) {
            if($dashboard['prefix'] == $action['prefix'] && $dashboard['namespace'] == $action['namespace'] && $dashboard['domain'] == $action['domain']) {
                $this->dashboard_name = $name;
                break;
            }
        }

        if($this->dashboard_name === null) {
            throw new \RuntimeException('Dashboard not found for current route');
        }

        $this->booted = true;
    }

    /**
     * @inheritdoc
     * */
    public function getConfig($key = null, $default = null)
    {
        return config( 'dashboard.dashboards.'.$this->getName().$key, $default);
    }

    /**
     * @inheritdoc
     * */
    public function getName()
    {
        return $this->dashboard_name;
    }

}