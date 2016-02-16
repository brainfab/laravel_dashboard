<?php namespace SmallTeam\Dashboard\Routing;

use Illuminate\Support\Arr;
use \Route;
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

    /** @var array|null */
    private $dashboards;

    /**
     * RoutesMapper constructor
     *
     * @param array $dashboards
     * */
    public function __construct($dashboards = [])
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
        if (!is_array($this->dashboards) || !count($this->dashboards)) {
            return;
        }

        foreach ($this->dashboards as $dashboard_alias => $dashboard) {
            $group = Arr::only($dashboard, [
                'entities', 'security', 'namespace', 'prefix', 'domain', 'base_list_controller'
            ]);

            $group['dashboard_alias'] = $dashboard_alias;

            if (!isset($group['entities']['index'])) {
                $group['entities']['index'] = \SmallTeam\Dashboard\Entity\DashboardEntity::class;
            }

            $cl = function () {
                foreach ($this->entities as $name => $entity_class_name) {
                    /** @var Entity\BaseEntity $entity */
                    $entity = app($entity_class_name);

                    $controller = $entity->getController();
                    $controller = $controller === null ? $this->base_list_controller : $controller;

                    $router = new Router($entity, $controller);
                    call_user_func([$controller, 'routesMap'], $router, $name, $controller, [
                        'namespace' => $this->namespace,
                        'prefix' => $this->prefix,
                        'domain' => $this->domain,
                        'entity' => $entity,
                    ]);
                }

                if (data_get($this->security, 'auth.enabled')) {
                    $auth_controller = data_get($this->security, 'auth.auth_controller');
                    $password_controller = data_get($this->security, 'auth.password_controller');

                    Route::get('/login', $auth_controller . '@showLoginForm');
                    Route::post('/login', $auth_controller . '@login');
                    Route::get('/logout', $auth_controller . '@logout');

                    Route::get('password/reset/{token?}', $password_controller . '@showResetForm');
                    Route::post('password/email', $password_controller . '@sendResetLinkEmail');
                    Route::post('password/reset', $password_controller . '@reset');
                    Route::get('password/reset', $password_controller . '@showResetForm');
                }
            };

            $cl = Closure::bind($cl, (object)$group);

            \Route::group([
                'middleware' => 'web',
                'namespace' => $group['namespace'],
                'prefix' => $group['prefix'],
                'domain' => $group['domain']
            ], $cl);

            unset($cl, $group);
        }
    }
}