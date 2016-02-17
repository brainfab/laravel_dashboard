<?php namespace SmallTeam\Dashboard\Controller;

use SmallTeam\Dashboard\Routing\Router;
use Illuminate\Routing\Controller as BaseController;
use SmallTeam\Dashboard\Dashboard;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Controller - base controller superclass
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
abstract class Controller extends BaseController implements ControllerInterface
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var bool|null */
    protected $guarded = null;

    /** @var array|null */
    protected $guarded_only = null;

    /** @var array|null */
    protected $guarded_except = null;

    public function __construct()
    {
        $this->guarded = $this->guarded === null ? $this->getDashboard()->get('security.auth.enabled', false) : $this->guarded;

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
    public function getDashboard()
    {
        return app('dashboard');
    }

}