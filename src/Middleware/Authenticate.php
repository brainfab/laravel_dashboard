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
        if ($this->auth->guest())
        {
            if ($request->ajax())
            {
                return response('Unauthorized.', 401);
            }
            else
            {
                /** @var \SmallTeam\Dashboard\DashboardApp $dashboard */
                $dashboard = app()->make('SmallTeam\Dashboard\DashboardApp');
                return redirect()->guest(url($dashboard->getPrefix().'auth/login'));
            }
        }

        return $next($request);
    }
}
