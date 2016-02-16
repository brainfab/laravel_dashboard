<?php namespace SmallTeam\Dashboard\Controller\Auth;

use SmallTeam\Dashboard\Routing\Router;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use SmallTeam\Dashboard\Controller\Controller;
use SmallTeam\Dashboard\Dashboard;
use Illuminate\Foundation\Auth\ThrottlesLogins;

/**
 * AuthController
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /** @var bool */
    protected $guarded = false;

    public function __construct(Dashboard $dashboard, Guard $auth = null, Registrar $registrar = null)
    {
        parent::__construct($dashboard);

        $this->auth = $auth;
        $this->registrar = $registrar;

        $this->redirectTo = $dashboard->url();
        $this->loginPath = $dashboard->url('login');

        $this->middleware('dashboard.guest', ['except' => 'getLogout']);
    }

    /**
     * @inheritdoc
     * */
    public function showLoginForm()
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

}