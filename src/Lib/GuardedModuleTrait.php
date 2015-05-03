<?php namespace SmallTeam\Dashboard;

trait GuardedModuleTrait {

    public function __construct() {
        $this->middleware($this->getAuthMiddleware());
    }

    public function getAuthMiddleware() {
        return 'dashboard.auth';
    }

    abstract public function middleware($middleware, array $options = array());

}