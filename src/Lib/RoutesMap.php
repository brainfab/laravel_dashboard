<?php namespace SmallTeam\Dashboard;

use Illuminate\Routing\Router;
use Illuminate\Support\Str;

class RoutesMap  {

    private $namespace = null;
    private $prefix = null;
    private $domain = null;

    private $modules = [];

    /**
     * @param array $modules
     * @param string $prefix
     * @param string $namespace
     * @param string $domain
     * */
    public function __construct($modules = [], $prefix = null, $namespace = null, $domain = null)
    {
        $this->setNamespace($namespace)
            ->setPrefix($prefix)
            ->setDomain($domain)
            ->setModules($modules)
        ;
    }

    /**
     * Get namespace
     *
     * @return string
     * */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set namespace
     *
     * @param string $namespace
     * @return RoutesMap
     * */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * Get prefix
     *
     * @return string
     * */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set prefix
     *
     * @param string $prefix
     * @return RoutesMap
     * */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * Get domain
     *
     * @return string
     * */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set domain
     *
     * @param string $domain
     * @return RoutesMap
     * */
    public function setDomain($domain)
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * Get modules
     *
     * @return array
     * */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * Set modules
     *
     * @param array $modules
     * @return RoutesMap
     * */
    public function setModules($modules)
    {
        $this->modules = is_array($modules) ? $modules : [];
        return $this;
    }

    /**
     * Define the routes for dashboard application.
     *
     * @return \Closure
     * */
    public function map()
    {
        $cl = function(Router $router) {
            foreach ($this->modules as $module_name => $module)
            {
                call_user_func([$module, 'routesMap'], $router, Str::lower($module_name), $module);
            }
        };

        $cl = \Closure::bind($cl, $this);

        return $cl;
    }
}