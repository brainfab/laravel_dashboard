<?php namespace SmallTeam\Dashboard;

use Illuminate\Routing\Router;
use SmallTeam\Dashboard\Entity\EntityInterface;

/**
 * Dashboard
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
class Dashboard implements DashboardInterface
{
    /** @var bool */
    private $booted = false;

    /** @var EntityInterface */
    private $entity;

    /** @var string */
    private $dashboard_alias;

    /** @var string */
    private $dashboard_prefix;

    /**
     * Dashboard constructor
     * */
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

        $this->entity = new $current->entity();
        $prefix = $this->getConfig('prefix', '/');
        $this->dashboard_prefix = substr($prefix, (strlen($prefix)-1), strlen($prefix)) != '/' ? $prefix.'/' : $prefix;
        \View::share('dashboard', $this);

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
    public function getShortName()
    {
        return $this->getConfig('short_name');
    }

    /**
     * @inheritdoc
     * */
    public function getAlias()
    {
        return $this->dashboard_alias;
    }

    /**
     * @inheritdoc
     * */
    public function getPrefix()
    {
        return $this->dashboard_prefix;
    }

    /**
     * @inheritdoc
     * */
    public function getEntity()
    {
        return $this->entity;
    }

}