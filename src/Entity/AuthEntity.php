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
    protected static $name = 'Auth';

    protected static $controller = 'SmallTeam\Dashboard\Controller\Auth\AuthController';

}