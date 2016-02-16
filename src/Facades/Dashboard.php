<?php namespace SmallTeam\Dashboard\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SmallTeam\Dashboard\Dashboard
 * */
class Dashboard extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'dashboard';
    }
}