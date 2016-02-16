<?php namespace SmallTeam\Dashboard\Controller\Auth;

use SmallTeam\Dashboard\Routing\Router;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use SmallTeam\Dashboard\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use SmallTeam\Dashboard\Dashboard;

/**
 * PasswordController
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
class PasswordController extends Controller
{
    use ResetsPasswords;

    /** @var bool */
    protected $guarded = false;

    public function __construct(Dashboard $dashboard, Guard $auth = null, PasswordBroker $passwords = null)
    {
        parent::__construct($dashboard);

        $this->auth = $auth;
        $this->passwords = $passwords;
        $this->redirectPath = $dashboard->url();
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
        if (is_null($token)) {
            abort(404);
        }

        return view('dashboard::auth.reset')->with('token', $token);
    }

}