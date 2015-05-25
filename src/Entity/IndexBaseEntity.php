<?php namespace SmallTeam\Dashboard\Entity;

/**
 * IndexBaseEntity
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 25.05.2015
 * */
class IndexBaseEntity extends BaseEntity
{

    protected $name = 'Home';

    protected $controller = 'SmallTeam\Dashboard\Controller\IndexBaseController';

}