<?php namespace SmallTeam\Dashboard\Controller;

use SmallTeam\Dashboard\Routing\Router;

/**
 * DashboardController
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
class DashboardController extends Controller implements DashboardControllerInterface
{

	public function index()
	{
        return view('dashboard::dashboard');
	}

}