<?php namespace SmallTeam\Dashboard\Controller\Auth;

use SmallTeam\Dashboard\Routing\Router;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use SmallTeam\Dashboard\Controller\DashboardController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use SmallTeam\Dashboard\Dashboard;

/**
 * PasswordController
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
class PasswordController extends DashboardController
{
    use ResetsPasswords;

    /** @var bool */
    protected $guarded = false;

    public function __construct(Dashboard $dashboard, Guard $auth = null, PasswordBroker $passwords = null)
    {
        parent::__construct($dashboard);

        $this->auth = $auth;
        $this->passwords = $passwords;
        $this->redirectPath = url($dashboard->getPrefix());
        $this->subject = 'Your Password Reset Link';

        $this->middleware('dashboard.guest');
    }

    /**
     * @inheritdoc
     */
    public function getEmail()
    {
        return view('dashboard::auth.password');
    }

    /**
     * @inheritdoc
     */
    public function getReset($token = null)
    {
        if (is_null($token))
        {
            throw new NotFoundHttpException;
        }

        return view('dashboard::auth.reset')->with('token', $token);
    }

    /**
     * @inheritdoc
     * */
    public static function routesMap(Router $router, $name, $controller, $parameters)
    {
        $router->get('/password/email', 'getEmail');
        $router->post('/password/email', 'postEmail');
        $router->get('/password/reset', 'getReset');
        $router->post('/password/reset', 'postReset');
    }

}