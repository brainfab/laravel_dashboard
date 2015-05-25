<?php namespace SmallTeam\Dashboard;

/**
 * EntityContainer
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 25.05.2015
 * */
class EntityContainer
{

    /** @var EntityContainer */
    private static $instance = null;

    /** @var array */
    private static $entity_container = [];

    final private function __construct() { }

    /**
     * Get EntityContainer instance
     *
     * @return EntityContainer
     * */
    public static function instance()
    {
        if(self::$instance === null) {
            self::$instance = new EntityContainer();
        }

        return self::$instance;
    }

    /**
     * Add entity
     *
     * @param string $dashboard_name
     * @param string $entity_alias
     * @param string $entity_class
     * @return EntityContainer
     * */
    public function add($dashboard_name, $entity_alias, $entity_class)
    {
        if(!isset(self::$entity_container[$dashboard_name][$entity_alias])) {
            self::$entity_container[$dashboard_name][$entity_alias] = new $entity_class();
        }

        return $this;
    }

    /**
     * Find entity
     *
     * @param string $dashboard_name
     * @param string $entity_alias
     * */
    public function find($dashboard_name, $entity_alias)
    {
        return isset(self::$entity_container[$dashboard_name][$entity_alias]) ? self::$entity_container[$dashboard_name][$entity_alias] : null;
    }

}