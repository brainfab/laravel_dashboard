<?php namespace SmallTeam\Dashboard\Routing;

use Illuminate\Routing\Router as BaseRouter;
use Illuminate\Routing\Route;
use SmallTeam\Dashboard\Entity\EntityInterface;

/**
 * Router
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 27.05.2015
 * */
class Router
{
    /** @var BaseRouter */
    protected $router;

    /** @var EntityInterface */
    protected $entity;

    /**
     * @param EntityInterface $entity
     * */
    public function __construct($entity)
    {
        $this->router = app()->router;
        $this->entity = $entity;
    }

    public function get($uri, $action)
    {
        $route = app()->router->get($uri, $action);
        $this->bindEntity($route);
    }

    public function post($uri, $action)
    {
        $route = app()->router->post($uri, $action);
        $this->bindEntity($route);
    }

    public function put($uri, $action)
    {
        $route = app()->router->put($uri, $action);
        $this->bindEntity($route);
    }

    public function patch($uri, $action)
    {
        $route = app()->router->patch($uri, $action);
        $this->bindEntity($route);
    }

    public function delete($uri, $action)
    {
        $route = app()->router->delete($uri, $action);
        $this->bindEntity($route);
    }

    public function options($uri, $action)
    {
        $route = app()->router->options($uri, $action);
        $this->bindEntity($route);
    }

    public function any($uri, $action)
    {
        $route = app()->router->any($uri, $action);
        $this->bindEntity($route);
    }

    protected function bindEntity(Route $route)
    {
        $route->entity = $this->entity;
    }

}