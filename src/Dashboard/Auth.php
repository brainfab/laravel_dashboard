<?php namespace SmallTeam\Dashboard;

/**
 * Auth
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 10.05.2015
 * */
class Auth implements AuthInterface
{

    /** @var array */
    private static $_instances = null;

    /** @var string */
    private $dashboard_alias = null;

    private function __construct($dashboard_alias)
    {
        $this->dashboard_alias = $dashboard_alias;
    }

    /**
     * @inheritdoc
     * */
    public static function create($dashboard_alias)
    {
        if(!isset(self::$_instances[$dashboard_alias]) || !is_object(self::$_instances[$dashboard_alias])) {
            self::$_instances[$dashboard_alias] = new Auth($dashboard_alias);
        }

        return self::$_instances[$dashboard_alias];
    }

    /**
     * @inheritdoc
     */
    public function guest()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function check()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function login($login, $password, $remember = false)
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function logout()
    {
        return;
    }

}