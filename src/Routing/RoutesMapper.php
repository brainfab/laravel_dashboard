<?php namespace SmallTeam\Dashboard\Routing;

use Illuminate\Routing\Router;
use Illuminate\Support\Str;

class RoutesMapper
{

    /** @var array|null */
    private $dashboards;

    /**
     * RoutesMapper constructor
     *
     * @param array|null $dashboards
     * */
    public function __construct($dashboards = null)
    {
        $this->dashboards = $dashboards;
    }

    /**
     * Define the routes for dashboard application.
     *
     * @return void
     * */
    public function map()
    {
        if(!is_array($this->dashboards) && count($this->dashboards) > 0) {
            return;
        }

        foreach ($this->dashboards as $dashboard) {
            $group = new \stdClass();
            $group->controllers = isset($dashboard['controllers']) && is_array($dashboard['controllers']) && count($dashboard['controllers']) > 0
                ? $dashboard['controllers']
                : [];

            $group->controllers['__auth'] = 'SmallTeam\Dashboard\Controller\Auth\AuthBaseController';
            $group->controllers['__password'] = 'SmallTeam\Dashboard\Controller\Auth\PasswordBaseController';

            $group->namespace = isset($dashboard['namespace']) && !empty($dashboard['namespace']) ? $dashboard['namespace'] : null;
            $group->prefix = isset($dashboard['prefix']) && !empty($dashboard['prefix']) ? $dashboard['prefix'] : null;
            $group->domain = isset($dashboard['domain']) && !empty($dashboard['domain']) ? $dashboard['domain'] : null;

            $cl = function(Router $router) {
                foreach ($this->controllers as $name => $controller)
                {
                    call_user_func([$controller, 'routesMap'], $router, $name, $controller, [
                        'namespace' => $this->namespace,
                        'prefix' => $this->prefix,
                        'domain' => $this->domain,
                    ]);
                }
            };

            $cl = \Closure::bind($cl, $group);

            \Route::group([
                'namespace' => $group->namespace,
                'prefix' => $group->prefix,
                'domain' => $group->domain
            ], $cl);

            unset($cl, $group);
        }
    }
}