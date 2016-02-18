<?php namespace SmallTeam\Dashboard\Controller;

use SmallTeam\Dashboard\Dashboard;
use SmallTeam\Dashboard\Routing\Router;

/**
 * ControllerInterface
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
interface ControllerInterface
{

    /**
     * Get dashboard application
     *
     * @return \SmallTeam\Dashboard\Dashboard
     * */
    public function getDashboard();

}