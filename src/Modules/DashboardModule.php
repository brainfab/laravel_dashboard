<?php namespace SmallTeam\Dashboard\Modules;

use Illuminate\Routing\Router;
use Illuminate\Routing\Controller as BaseController;
use SmallTeam\Dashboard\DashboardModuleInterface;
use SmallTeam\Dashboard\DashboardApp;

/**
 * DashboardModule - base module superclass
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
class DashboardModule extends BaseController implements DashboardModuleInterface
{

    /** @var DashboardApp */
    private $dashboard;

    /** @var bool */
    protected $guarded_module = true;

    /** @var null */
    private $menu_factory = null;

    /** @var null */
    private $menu = null;

    public function __construct(DashboardApp $app)
    {
        $this->dashboard = $app;

        if($this->guarded_module) {
            $this->middleware($this->getAuthMiddleware());
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
    public static function routesMap(Router $router, $module_name, $module)
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