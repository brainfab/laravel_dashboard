<?php namespace SmallTeam\Dashboard;

use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
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

    /** @var string */
    protected $dashboard_alias;

    /** @var EntityInterface */
    protected $entity;

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
        if ($this->booted) {
            return;
        }

        /** @var Router $router */
        $router = app()->router;
        $current = $router->current();
        $action = $current ? $current->getAction() : null;
        $dashboard_alias = null;

        $as = data_get($action, 'as');

        if ($as) {
            $as_arr = explode('.', $as);
            $is_dashboard = data_get($as_arr, 0) === 'dashboard';

            if ($is_dashboard) {
                $dashboard_alias = data_get($as_arr, 1);
                $this->entity = app($as);
            }
        }

        if (!app()->runningInConsole() && $dashboard_alias === null) {
            abort('Dashboard not found for current route', 404);
        }

        $this->dashboard_alias = $dashboard_alias;

        $prefix = $this->get('prefix', '/');

        $dashboard_prefix = substr($prefix, (strlen($prefix) - 1), strlen($prefix)) != '/' ? $prefix . '/' : $prefix;
        $this->set('dashboard_prefix', $dashboard_prefix);
        $locales = config('dashboard.locales', []);
        $this->set('locales', $locales);

        if (request()->has('_locale') && in_array(request('_locale'), $locales)) {
            session()->put('dashboards/' . $dashboard_alias . '/locale', request('_locale'));
        }

        $locale = session('dashboards/' . $dashboard_alias . '/locale', $this->get('default_locale'));
        $locale = in_array($locale, $locales) ? $locale : $this->get('default_locale');
        session()->put('dashboards/' . $dashboard_alias . '/locale', $locale);

        $this->setCurrentLocale($locale);
        app()->setLocale($locale);

        $this->booted = true;
    }

    /**
     * @inheritdoc
     * */
    public function get($key = null, $default = null)
    {
        return config('dashboard.dashboards.' . $this->getAlias() . ($key !== null ? '.' . $key : ''), $default);
    }

    /**
     * @inheritdoc
     * */
    public function set($key, $value)
    {
        if (empty($key)) {
            throw new \InvalidArgumentException();
        }

        $key = 'dashboard.dashboards.' . $this->getAlias() . '.' . $key;
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
        return $this->dashboard_alias;
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
    public function url($path = null, $parameters = [], $secure = null)
    {
        return url($this->get('dashboard_prefix') . $path, $parameters, $secure);
    }

    /**
     * @inheritdoc
     * */
    public function getEntity()
    {
        return $this->entity;
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