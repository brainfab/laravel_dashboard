<?php namespace SmallTeam\Dashboard\Entity;

/**
 * AuthEntity
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 25.05.2015
 * */
class AuthEntity extends BaseEntity
{
    protected $name = 'Auth';

    protected $controller = 'SmallTeam\Dashboard\Controller\Auth\AuthController';

}