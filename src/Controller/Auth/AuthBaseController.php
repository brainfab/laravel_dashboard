<?php namespace SmallTeam\Dashboard\Controller\Auth;

use SmallTeam\Dashboard\Routing\Router;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use SmallTeam\Dashboard\Controller\DashboardController;
use SmallTeam\Dashboard\Dashboard;

/**
 * AuthBaseController
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
class AuthBaseController extends DashboardController
{
    use AuthenticatesAndRegistersUsers;

    /** @var bool */
    protected $guarded = false;

    public function __construct(Dashboard $dashboard, Guard $auth = null, Registrar $registrar = null)
    {
        parent::__construct($dashboard);

        $this->auth = $auth;
        $this->registrar = $registrar;

        $this->redirectPath = url($dashboard->getPrefix());
        $this->loginPath = url($dashboard->getPrefix().'auth/login');

        $this->middleware($this->getGuestMiddleware(), ['except' => 'getLogout']);
    }

    /**
     * @inheritdoc
     * */
    public function getRegister()
    {
        return view('dashboard::auth.register');
    }

    /**
     * @inheritdoc
     * */
    public function getLogin()
    {
        return view('dashboard::auth.login');
    }

    /**
     * @inheritdoc
     */
    protected function getFailedLoginMessage()
    {
        return 'These credentials do not match our records.';
    }

    /**
     * @inheritdoc
     * */
    public static function routesMap(Router $router, $name, $controller, $parameters)
    {
        $router->post('/auth/register', 'postRegister');
        $router->get('/auth/login', 'getLogin');
        $router->post('/auth/login', 'postLogin');
        $router->get('/auth/logout', 'getLogout');
    }

}