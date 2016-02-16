<?php namespace SmallTeam\Dashboard\Entity;

use SmallTeam\Dashboard\Controller\DashboardController;

/**
 * DashboardEntity
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 25.05.2015
 * */
class DashboardEntity extends BaseEntity
{

    protected $name = 'Dashboard';

    protected $controller = DashboardController::class;

}