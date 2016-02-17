<?php namespace SmallTeam\Dashboard\Routing;

use Illuminate\Support\Arr;
use \Route;
use SmallTeam\Dashboard\Controller\CRUDControllerInterface;
use SmallTeam\Dashboard\Controller\DashboardControllerInterface;
use SmallTeam\Dashboard\Controller\SingleFormControllerInterface;
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

        $self = $this;

        foreach ($this->dashboards as $dashboard_alias => $dashboard) {
            $data = Arr::only($dashboard, [
                'entities', 'security', 'namespace',
                'prefix', 'domain', 'base_list_controller'
            ]);

            $data['dashboard_alias'] = $dashboard_alias;

            if (!isset($data['entities']['index'])) {
                $data['entities']['index'] = \SmallTeam\Dashboard\Entity\DashboardEntity::class;
            }

            \Route::group([
                'middleware' => 'web',
                'namespace' => $data['namespace'],
                'prefix' => $data['prefix'],
                'domain' => $data['domain']
            ], function () use ($data, $self) {
                foreach ($data['entities'] as $name => $entity_class_name) {

                    $prefix = $name === 'index' ? '/' : $name;

                    /** @var Entity\EntityInterface $entity */
                    $entity = app($entity_class_name);

                    $controller = $entity->getController();
                    $controller = $controller === null ? $data['base_list_controller'] : $controller;

                    $router = Router::create($entity, $controller, $prefix);
                    $arguments = [
                        $router, $name, [
                            'namespace' => $data['namespace'],
                            'prefix' => $data['prefix'],
                            'domain' => $data['domain'],
                            'entity' => $entity,
                            'controller' => $controller
                        ]
                    ];

                    app()->bind('dashboard.' . $data['dashboard_alias'] . '.' . $name, function () use ($entity) {
                        return $entity;
                    });

                    if (is_a($controller, CRUDControllerInterface::class, true)) {
                        call_user_func_array([$self, 'mapCRUDRoutes'], $arguments);
                    } elseif (is_a($controller, SingleFormControllerInterface::class, true)) {
                        call_user_func_array([$self, 'mapSingleFormRoutes'], $arguments);
                    } elseif (is_a($controller, DashboardControllerInterface::class, true)) {
                        call_user_func_array([$self, 'mapDashboardRoutes'], $arguments);
                    }

                    call_user_func_array([$entity, 'routesMap'], $arguments);
                }

                if (data_get($data['security'], 'auth.enabled')) {
                    $auth_controller = data_get($data['security'], 'auth.auth_controller');
                    $password_controller = data_get($data['security'], 'auth.password_controller');

                    $self->mapAuthAndPasswordRoutes($auth_controller, $password_controller);
                }
            });
        }
    }

    /**
     * Map auth and password routes.
     *
     * @param string $auth_controller Auth Controller class name.
     * @param string $password_controller Password Controller class name.
     *
     * @return void
     * */
    protected function mapAuthAndPasswordRoutes($auth_controller, $password_controller)
    {
        Route::get('/login', $auth_controller . '@showLoginForm');
        Route::post('/login', $auth_controller . '@login');
        Route::get('/logout', $auth_controller . '@logout');

        Route::get('password/reset/{token?}', $password_controller . '@showResetForm');
        Route::post('password/email', $password_controller . '@sendResetLinkEmail');
        Route::post('password/reset', $password_controller . '@reset');
        Route::get('password/reset', $password_controller . '@showResetForm');
    }

    /**
     * Map CRUD routes.
     *
     * @param Router $router
     * @param string $name Entity name.
     * @param array $parameters
     *
     * @return void
     * */
    protected function mapCRUDRoutes(Router $router, $name, array $parameters)
    {
        $router->get('/', 'index');

        $router->get('create', 'create');
        $router->post('/', 'store');

        $router->get('{id}/edit', 'edit')->where('id', '[0-9]+');
        $router->put('{id}', 'update')->where('id', '[0-9]+');

        $router->get('{id}/show', 'show')->where('id', '[0-9]+');

        $router->delete('{id}', 'destroy')->where('id', '[0-9]+');
    }

    /**
     * Map Single Form routes.
     *
     * @param Router $router
     * @param string $name Entity name.
     * @param array $parameters
     *
     * @return void
     * */
    protected function mapSingleFormRoutes(Router $router, $name, array $parameters)
    {
        $router->get($name, 'edit');
        $router->put($name, 'update');
    }

    /**
     * Map Dashboard routes.
     *
     * @param Router $router
     * @param string $name Entity name.
     * @param array $parameters
     *
     * @return void
     * */
    protected function mapDashboardRoutes(Router $router, $name, array $parameters)
    {
        $router->get('/', 'index');
    }
}