<?php namespace SmallTeam\Dashboard\Routing;

use SmallTeam\Dashboard\Entity;
use Closure;

/**
 * RoutesMapper
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
class RoutesMapper
{

    const BASE_LIST_CONTROLLER = 'SmallTeam\Dashboard\Controller\ListBaseController';
    const BASE_SINGLE_CONTROLLER = 'SmallTeam\Dashboard\Controller\SingleBaseController';
    const BASE_INDEX_CONTROLLER = 'SmallTeam\Dashboard\Controller\IndexBaseController';

    /** @var array|null */
    private $dashboards;

    /** @var array */
    private static $registered = [];

    /**
     * Check controller registered for dashboard
     *
     * @param string $dashboard_alias
     * @param string $controller_prefix
     * @return bool
     * */
    public static function isRegistered($dashboard_alias, $controller_prefix)
    {
        return isset(self::$registered[$dashboard_alias][$controller_prefix]);
    }

    /**
     * Register entity for dashboard
     *
     * @param string $dashboard_alias
     * @param string $controller_prefix
     * @return void
     * */
    public static function noteAsRegistered($dashboard_alias, $controller_prefix)
    {
        self::$registered[$dashboard_alias][$controller_prefix] = true;
    }

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

        foreach ($this->dashboards as $dashboard_alias => $dashboard) {
            $group['dashboard_alias'] = $dashboard_alias;

            $group['entities'] = isset($dashboard['entities']) && is_array($dashboard['entities']) && count($dashboard['entities']) > 0
                ? $dashboard['entities']
                : [];

            if(isset($dashboard['security']['auth']['auth_entity']) && !empty($dashboard['security']['auth']['auth_entity']))
            {
                $group['entities']['__auth'] = $dashboard['security']['auth']['auth_entity'];
            }

            if(isset($dashboard['security']['auth']['password_entity']) && !empty($dashboard['security']['auth']['password_entity']))
            {
                $group['entities']['__password'] = $dashboard['security']['auth']['password_entity'];
            }

            if(!isset($group['entities']['/'])) {
                $group['entities']['/'] = 'SmallTeam\Dashboard\Entity\IndexEntity';
            }

            $group['namespace'] = isset($dashboard['namespace']) && !empty($dashboard['namespace']) ? $dashboard['namespace'] : null;
            $group['prefix'] = isset($dashboard['prefix']) && !empty($dashboard['prefix']) ? $dashboard['prefix'] : null;
            $group['domain'] = isset($dashboard['domain']) && !empty($dashboard['domain']) ? $dashboard['domain'] : null;

            $cl = function()
            {
                foreach ($this->entities as $name => $entity)
                {
                    /** @var Entity\BaseEntity $entity */
                    $controller = $entity::getController();
                    $controller = $controller === null ? self::BASE_LIST_CONTROLLER : $controller;

                    if(RoutesMapper::isRegistered($this->dashboard_alias, $name)) {
                        continue;
                    }

                    $router = new Router($entity, $controller);
                    call_user_func([$controller, 'routesMap'], $router, $name, $controller, [
                        'namespace' => $this->namespace,
                        'prefix' => $this->prefix,
                        'domain' => $this->domain,
                        'entity' => $entity,
                    ]);

                    RoutesMapper::noteAsRegistered($this->dashboard_alias, $name);
                }
            };

            $cl = Closure::bind($cl, (object)$group);

            \Route::group([
                'namespace' => $group['namespace'],
                'prefix' => $group['prefix'],
                'domain' => $group['domain']
            ], $cl);

            unset($cl, $group);
        }
    }
}