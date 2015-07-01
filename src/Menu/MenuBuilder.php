<?php namespace SmallTeam\Menu;
use SmallTeam\Dashboard\DashboardInterface;

/**
 * MenuBuilder
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 29.06.2015
 * */
class MenuBuilder
{

    /** @var DashboardInterface */
    protected $dashboard;

    public function __construct(DashboardInterface $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    public function build()
    {
        $entities = $this->dashboard->get('entities');

        if(!count($entities)) {
            return null;
        }

        foreach ($entities as $name => $entity) {

        }

    }

}