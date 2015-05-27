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
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_PATCH = 'PATCH';
    const METHOD_DELETE = 'DELETE';
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_ANY = 'ANY';

    /** @var BaseRouter */
    protected $router;

    /** @var EntityInterface */
    protected $entity;

    /** @var string */
    protected $controller_name;

    /** @var array */
    public static $methods = array('GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS', 'ANY');

    /**
     * Router constructor
     *
     * @param EntityInterface $entity
     * @param string $controller_name
     * */
    public function __construct($entity, $controller_name)
    {
        $this->router = app()->router;
        $this->entity = $entity;
        $this->controller_name = $controller_name;
    }

    /**
     * @param string $uri
     * @param string $action Current controller action
     * @return Route
     * */
    public function get($uri, $action)
    {
        return $this->addRoute(self::METHOD_GET, $uri, $action);
    }

    /**
     * @param string $uri
     * @param string $action Current controller action
     * @return Route
     * */
    public function post($uri, $action)
    {
        return $this->addRoute(self::METHOD_POST, $uri, $action);
    }

    /**
     * @param string $uri
     * @param string $action Current controller action
     * @return Route
     * */
    public function put($uri, $action)
    {
        return $this->addRoute(self::METHOD_PUT, $uri, $action);
    }

    /**
     * @param string $uri
     * @param string $action Current controller action
     * @return Route
     * */
    public function patch($uri, $action)
    {
        return $this->addRoute(self::METHOD_PATCH, $uri, $action);
    }

    /**
     * @param string $uri
     * @param string $action Current controller action
     * @return Route
     * */
    public function delete($uri, $action)
    {
        return $this->addRoute(self::METHOD_DELETE, $uri, $action);
    }

    /**
     * @param string $uri
     * @param string $action Current controller action
     * @return Route
     * */
    public function options($uri, $action)
    {
        return $this->addRoute(self::METHOD_OPTIONS, $uri, $action);
    }

    /**
     * @param string $uri
     * @param string $action Current controller action
     * @return Route
     * */
    public function any($uri, $action)
    {
        return $this->addRoute(self::METHOD_ANY, $uri, $action);
    }

    /**
     * Add route
     *
     * @param string $method
     * @param string $uri
     * @param string $action
     * @return Route
     * @throws \InvalidArgumentException
     * */
    protected function addRoute($method, $uri, $action)
    {
        if(!is_string($action)) {
            throw new \InvalidArgumentException('Action must be string "'.$action.'"');
        }

        if(!in_array($method, self::$methods)) {
            throw new \InvalidArgumentException('Invalid method "'.$method.'"');
        }

        if(strpos($action, '@') !== false) {
            $action_arr = explode('@', $action);
            $action = array_pop($action_arr);
        }

        $route = call_user_func([$this->router, strtolower($method)], $uri, $this->controller_name.'@'.$action);
        $this->bindEntity($route);

        return $route;
    }

    /**
     * Bind entity to route
     *
     * @param Route $route
     * */
    protected function bindEntity(Route $route)
    {
        $route->entity = $this->entity;
    }

}