<?php namespace SmallTeam\Dashboard\Controller;

use Illuminate\Routing\Router;
use Illuminate\Routing\Controller as BaseController;
use SmallTeam\Dashboard\Dashboard;

/**
 * DashboardController - base controller superclass
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
class DashboardController extends BaseController implements DashboardControllerInterface
{

    /** @var Dashboard */
    private $dashboard;

    /** @var bool */
    protected $guarded = false;

    /** @var array|null */
    protected $guarded_only = null;

    /** @var array|null */
    protected $guarded_except = null;

    /** @var null */
    private $menu_factory = null;

    /** @var null */
    private $menu = null;

    public function __construct(Dashboard $app)
    {
        $this->dashboard = $app;

        if($this->guarded) {
            $options = [];
            if(is_array($this->guarded_only) && count($this->guarded_only) > 0) {
                $options['only'] = $this->guarded_only;
            }

            if(is_array($this->guarded_except) && count($this->guarded_except) > 0) {
                $options['except'] = $this->guarded_except;
            }

            $this->middleware($this->getAuthMiddleware(), $options);
        }
    }

    /**
     * @inheritdoc
     * */
    public function getAuthMiddleware()
    {
        return 'dashboard.auth';
    }

    /**
     * @inheritdoc
     * */
    public function getGuestMiddleware()
    {
        return 'dashboard.guest';
    }

    /**
     * @inheritdoc
     * */
    public static function routesMap(Router $router, $name, $controller, $parameters)
    {
        //define routes
    }

    /**
     * @inheritdoc
     * */
    public function getDashboardName()
    {
        return $this->dashboard->getName();
    }

    /**
     * @inheritdoc
     * */
    public function getDashboard()
    {
        return $this->dashboard;
    }

    /**
     * @inheritdoc
     * */
    public function getDashboardConfig($key = null, $default = null)
    {
        return $this->dashboard->getConfig($key, $default);
    }

    /**
     * @inheritdoc
     * */
    public function getMenuFactory()
    {
        return $this->menu_factory;
    }

    /**
     * @inheritdoc
     * */
    public function getMenu()
    {
        return $this->menu;
    }

}