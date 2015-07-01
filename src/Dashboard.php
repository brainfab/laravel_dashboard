<?php namespace SmallTeam\Dashboard;

use Illuminate\Routing\Router;

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
        $dashboard_alias = null;
        foreach ($dashboards as $name => $dashboard) {
            if($dashboard['prefix'] == $action['prefix'] && $dashboard['namespace'] == $action['namespace'] && $dashboard['domain'] == $action['domain']) {
                $dashboard_alias = $name;
                break;
            }
        }

        if(!\App::runningInConsole() && $dashboard_alias === null) {
            throw new \RuntimeException('Dashboard not found for current route');
        }

        $this->set('entity', $current->entity);
        $prefix = $this->get('prefix', '/');

        $dashboard_prefix = substr($prefix, (strlen($prefix)-1), strlen($prefix)) != '/' ? $prefix.'/' : $prefix;
        $this->set('dashboard_prefix', $dashboard_prefix);

        $locales = config('dashboard.locales', []);
        $this->set('locales', $locales);

        if(\Input::has('_locale') && in_array(\Input::get('_locale'), $locales)) {
            \Session::put('dashboards/'.$dashboard_alias.'/locale', \Input::get('_locale'));
        }

        $locale = \Session::get('dashboards/'.$dashboard_alias.'/locale', $this->get('default_locale'));
        $locale = in_array($locale, $locales) ? $locale : $this->get('default_locale');
        \Session::put('dashboards/'.$dashboard_alias.'/locale', $locale);

        $this->setCurrentLocale($locale);
        \App::setLocale($locale);

        \View::share('dashboard', $this);

        $this->booted = true;
    }

    /**
     * @inheritdoc
     * */
    public function get($key = null, $default = null)
    {
        return config( 'dashboard.dashboards.'.$this->getAlias().($key !== null ? '.'.$key : ''), $default);
    }

    /**
     * @inheritdoc
     * */
    public function set($key, $value)
    {
        if(empty($key)) {
            throw new \InvalidArgumentException();
        }

        $key = 'dashboard.dashboards.'.$this->getAlias().'.'.$key;
        config([$key => $value]);

        return $this;
    }

    /**
     * @inheritdoc
     * */
    public function getName()
    {
        return $this->get('name');
    }

    /**
     * @inheritdoc
     * */
    public function getShortName()
    {
        return $this->get('short_name');
    }

    /**
     * @inheritdoc
     * */
    public function getAlias()
    {
        return $this->get('dashboard_alias');
    }

    /**
     * @inheritdoc
     * */
    public function getPrefix()
    {
        return $this->get('dashboard_prefix');
    }

    /**
     * @inheritdoc
     * */
    public function getEntity()
    {
        return $this->get('entity');
    }

    /**
     * @inheritdoc
     * */
    public function getCurrentLocale()
    {
        return $this->get('locale');
    }

    /**
     * @inheritdoc
     * */
    public function setCurrentLocale($locale)
    {
        $this->set('locale', $locale);
    }

    /**
     * @inheritdoc
     * */
    public function getLocales()
    {
        return $this->get('locales');
    }

}