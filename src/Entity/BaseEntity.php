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
    protected static $name;

    /** @var string */
    protected static $model;

    /** @var string */
    protected static $controller;

    /** @var array */
    protected static $fields;

    /**
     * Get entity name
     *
     * @return string|null
     * */
    public static function getName()
    {
        return static::$name;
    }

    /**
     * Get model name
     *
     * @return string|null
     * */
    public static function getModel()
    {
        return static::$model;
    }

    /**
     * Get controller name
     *
     * @return string|null
     * */
    public static function getController()
    {
        return static::$controller;
    }

    /**
     * Get fields list
     *
     * @return array|null
     * */
    public static function getFields()
    {
        return static::$fields;
    }

}