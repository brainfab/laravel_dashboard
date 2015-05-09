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
    private $dashboard_alias = null;

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
        $action = $current ? $current->getAction() : null;

        $dashboards = config('dashboard.dashboards');
        foreach ($dashboards as $name => $dashboard) {
            if($dashboard['prefix'] == $action['prefix'] && $dashboard['namespace'] == $action['namespace'] && $dashboard['domain'] == $action['domain']) {
                $this->dashboard_alias = $name;
                break;
            }
        }

        if(!\App::runningInConsole() && $this->dashboard_alias === null) {
            throw new \RuntimeException('Dashboard not found for current route');
        }

        $this->booted = true;
    }

    /**
     * @inheritdoc
     * */
    public function getConfig($key = null, $default = null)
    {
        return config( 'dashboard.dashboards.'.$this->getAlias().($key !== null ? '.'.$key : ''), $default);
    }

    /**
     * @inheritdoc
     * */
    public function getName()
    {
        return $this->getConfig('name');
    }

    /**
     * @inheritdoc
     * */
    public function getAlias()
    {
        return $this->dashboard_alias;
    }

}