<?php namespace SmallTeam\Dashboard\Entity;

/**
 * PasswordEntity
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 25.05.2015
 * */
class PasswordEntity extends BaseEntity
{

    protected static $name = 'Password';

    protected static $controller = 'SmallTeam\Dashboard\Controller\Auth\PasswordController';

}