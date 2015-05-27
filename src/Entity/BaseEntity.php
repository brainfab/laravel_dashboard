<?php namespace SmallTeam\Dashboard\Entity;

/**
 * Entity
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 24.05.2015
 * */
abstract class BaseEntity implements EntityInterface
{

    /** @var string */
    protected $name;

    /** @var string */
    protected $model;

    /** @var string */
    protected $controller;

    /** @var array */
    protected $fields;

    /**
     * Get entity name
     *
     * @return string|null
     * */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get model name
     *
     * @return string|null
     * */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get controller name
     *
     * @return string|null
     * */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Get fields list
     *
     * @return array|null
     * */
    public function getFields()
    {
        return $this->fields;
    }

}