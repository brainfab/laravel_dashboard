<?php namespace SmallTeam\Dashboard\Entity;

use SmallTeam\Dashboard\Routing\Router;

/**
 * Entity.
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 24.05.2015
 * */
abstract class Entity implements EntityInterface
{

    /** @var string */
    protected $name;

    /** @var string */
    protected $model;

    /** @var string */
    protected $controller;

    /** @var array */
    protected $order_by;

    /** @var string */
    protected $icon;

    /**
     * @inheritdoc
     * */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     * */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @inheritdoc
     * */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @inheritdoc
     * */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @inheritdoc
     * */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @inheritdoc
     * */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @inheritdoc
     * */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @inheritdoc
     * */
    public function setController($controller)
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * @inheritdoc
     * */
    public function getOrderBy()
    {
        //return ['id' => 'asc'];
    }

    /**
     * @inheritdoc
     * */
    public function setOrderBy($order_by)
    {
        $this->order_by = $order_by;
    }

    /**
     * @inheritdoc
     * */
    public function configureFormFields()
    {
        //form fields definition
    }

    /**
     * @inheritdoc
     * */
    public function configureShowFields()
    {
        //show fields definition
    }

    /**
     * @inheritdoc
     * */
    public function configureListFields()
    {
        //list fields definition
    }

    /**
     * @inheritdoc
     * */
    public function configureFilterFields()
    {
        //filter fields definition
    }

    /**
     * @inheritdoc
     * */
    public static function routesMap(Router $router)
    {
        //set your custom routes here
    }

}