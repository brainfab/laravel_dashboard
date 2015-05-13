<?php namespace SmallTeam\Dashboard\Modules\Auth;

use Illuminate\Routing\Router;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use SmallTeam\Dashboard\DashboardApp;
use SmallTeam\Dashboard\Modules\DashboardModule;

/**
 * AuthBaseModule
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
class AuthBaseModule extends DashboardModule
{
    use AuthenticatesAndRegistersUsers;

    /** @var bool */
    protected $guarded_module = false;

    public function __construct(DashboardApp $app, Guard $auth = null, Registrar $registrar = null)
    {
        parent::__construct($app);

        $this->auth = $auth;
        $this->registrar = $registrar;

        $this->redirectPath = url($app->getPrefix());
        $this->loginPath = url($app->getPrefix().'auth/login');

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
    public static function routesMap(Router $router, $module_name, $module, $prefix)
    {
        $router->get('/auth/register', $module.'@getRegister');
        $router->post('/auth/register', $module.'@postRegister');

        $router->get('/auth/login', $module.'@getLogin');
        $router->post('/auth/login', $module.'@postLogin');

        $router->get('/auth/logout', $module.'@getLogout');
    }

}