<?php namespace SmallTeam\Dashboard\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use \SmallTeam\Dashboard\Auth;

class Authenticate
{

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        /** @var \SmallTeam\Dashboard\DashboardApp $dashboard */
        $dashboard = app()->make('SmallTeam\Dashboard\DashboardApp');
        $guard = Auth::create($dashboard->getAlias());

		if ($guard->guest())
		{
			if ($request->ajax())
			{
				return response('Unauthorized.', 401);
			}
			else
			{
				return redirect()->guest(route('Dashboard.'.$dashboard->getAlias().'.getLogin'));
			}
		}

		return $next($request);
	}

}
