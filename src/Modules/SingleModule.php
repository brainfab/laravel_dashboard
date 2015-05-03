<?php namespace SmallTeam\Dashboard\Modules;

class SingleModule extends DashboardModule
{

    use \SmallTeam\Dashboard\GuardedModuleTrait;

    function anyIndex()
    {
        return get_class($this).'::index';
    }

}