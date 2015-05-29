<?php namespace SmallTeam\Dashboard\Controller;

use SmallTeam\Dashboard\Routing\Router;
use Illuminate\Routing\Controller as BaseController;
use SmallTeam\Dashboard\Dashboard;
use SmallTeam\Dashboard\Entity\BaseEntity;

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

    /** @var bool|null */
    protected $guarded = null;

    /** @var array|null */
    protected $guarded_only = null;

    /** @var array|null */
    protected $guarded_except = null;

    public function __construct(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;

        $this->guarded = $this->guarded === null ? $dashboard->getConfig('security.auth.enabled', false) : $this->guarded;

        if($this->guarded) {
            $options = [];
            if(is_array($this->guarded_only) && count($this->guarded_only) > 0) {
                $options['only'] = $this->guarded_only;
            }

            if(is_array($this->guarded_except) && count($this->guarded_except) > 0) {
                $options['except'] = $this->guarded_except;
            }

            $this->middleware('dashboard.auth', $options);
        }
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

}