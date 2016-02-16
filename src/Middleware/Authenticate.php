<?php namespace SmallTeam\Dashboard\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use \Illuminate\Http\Request;

class Authenticate
{

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(app('dashboard')->url('login'));
            }
        }

        return $next($request);
    }
}
