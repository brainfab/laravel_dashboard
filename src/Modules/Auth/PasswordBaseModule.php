<?php namespace SmallTeam\Dashboard\Modules\Auth;

use Illuminate\Routing\Router;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use SmallTeam\Dashboard\DashboardApp;
use SmallTeam\Dashboard\Modules\DashboardModule;

/**
 * PasswordBaseModule
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
class PasswordBaseModule extends DashboardModule
{
    use ResetsPasswords;

    /** @var bool */
    protected $guarded_module = false;

    public function __construct(DashboardApp $app, Guard $auth = null, PasswordBroker $passwords = null)
    {
        parent::__construct($app);

        $this->auth = $auth;
        $this->passwords = $passwords;
        $this->redirectPath = url($app->getPrefix());
        $this->subject = 'Your Password Reset Link';

        $this->middleware($this->getGuestMiddleware());
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
    public static function routesMap(Router $router, $module_name, $module, $prefix)
    {
        $router->get('/password/email', $module.'@getEmail');
        $router->post('/password/email', $module.'@postEmail');

        $router->get('/password/reset', $module.'@getReset');
        $router->post('/password/reset', $module.'@postReset');
    }

}