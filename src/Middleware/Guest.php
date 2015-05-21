<?php namespace SmallTeam\Dashboard\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;

class Guest
{

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if ($this->auth->check())
        {
            /** @var \SmallTeam\Dashboard\Dashboard $dashboard */
            $dashboard = app()->make('SmallTeam\Dashboard\Dashboard');
            return new RedirectResponse(url($dashboard->getPrefix()));
        }

        return $next($request);
    }

}