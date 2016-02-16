<?php namespace SmallTeam\Dashboard\Controller\Auth;

use SmallTeam\Dashboard\Routing\Router;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use SmallTeam\Dashboard\Controller\Controller;
use SmallTeam\Dashboard\Dashboard;

/**
 * AuthController
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers;

    /** @var bool */
    protected $guarded = false;

    public function __construct(Dashboard $dashboard, Guard $auth = null, Registrar $registrar = null)
    {
        parent::__construct($dashboard);

        $this->auth = $auth;
        $this->registrar = $registrar;

        $this->redirectPath = $dashboard->url();
        $this->loginPath = $dashboard->url('login');

        $this->middleware('dashboard.guest', ['except' => 'getLogout']);
    }

    /**
     * @inheritdoc
     * */
    public function getRegister()
    {
        abort(404);
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

}