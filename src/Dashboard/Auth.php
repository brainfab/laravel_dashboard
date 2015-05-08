<?php namespace SmallTeam\Dashboard;

class Auth
{

    private static $_instance = null;

    private function __construct() {}

    /**
     * @return \SmallTeam\Dashboard\Auth;
     * */
    public static function getInstance()
    {
        if(self::$_instance === null) {
            self::$_instance = new Auth();
        }

        return self::$_instance;
    }

    /**
     * Determine if the current user is guest.
     *
     * @return bool
     */
    public function guest()
    {
        return false;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return true;
    }

    /**
     * Log a user into the application.
     *
     * @param string $login
     * @param string $password
     * @param bool $remember
     * @return bool
     */
    public function login($login, $password, $remember = false)
    {
        return true;
    }

    /**
     * Log the user out of the application.
     *
     * @return void
     */
    public function logout()
    {
        return;
    }

}