<?php namespace SmallTeam\Dashboard\Controller\Auth;

use Illuminate\Http\Request;
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

    public function __construct(Guard $auth = null, PasswordBroker $passwords = null)
    {
        parent::__construct();

        $this->auth = $auth;
        $this->passwords = $passwords;
        $this->redirectPath = app('dashboard')->url();
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
    public function showResetForm(Request $request, $token = null)
    {
        if (is_null($token)) {
            return $this->getEmail();
        }

        $email = $request->input('email');

        if (view()->exists('auth.passwords.reset')) {
            return view('auth.passwords.reset')->with(compact('token', 'email'));
        }

        return view('dashboard::auth.reset')->with('token', $token);
    }

}