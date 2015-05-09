<?php namespace SmallTeam\Dashboard;

/**
 * AuthInterface
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 10.05.2015
 * */
interface AuthInterface {

    /**
     * Create auth instance for dashboard
     *
     * @param string $dashboard_alias
     * @return Auth
     * */
    public static function create($dashboard_alias);

    /**
     * Determine if the current user is guest.
     *
     * @return bool
     */
    public function guest();

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check();

    /**
     * Log a user into the application.
     *
     * @param string $login
     * @param string $password
     * @param bool $remember
     * @return bool
     */
    public function login($login, $password, $remember = false);

    /**
     * Log the user out of the application.
     *
     * @return void
     */
    public function logout();

}