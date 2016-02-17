<?php namespace SmallTeam\Dashboard\Entity;
use SmallTeam\Dashboard\Routing\Router;

/**
 * EntityInterface
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 27.05.2015
 * */
interface EntityInterface
{
    /**
     * Get entity name
     *
     * @return string|null
     * */
    public function getName();

    /**
     * Set entity name
     *
     * @param string $name
     *
     * @return EntityInterface
     * */
    public function setName($name);

    /**
     * Get model name
     *
     * @return string|null
     * */
    public function getModel();

    /**
     * Set model name
     *
     * @param string $model
     *
     * @return EntityInterface
     * */
    public function setModel($model);

    /**
     * Get controller name
     *
     * @return string|null
     * */
    public function getController();

    /**
     * Set controller name
     *
     * @param string $controller
     *
     * @return EntityInterface
     * */
    public function setController($controller);

    /**
     * Get sort by: 'id' => 'asc'
     *
     * @return array|null
     * */
    public function getOrderBy();

    /**
     * Set sort by
     *
     * @param array $order_by
     *
     * @return EntityInterface
     * */
    public function setOrderBy($order_by);

    /**
     * Configure form fields
     *
     * @return array|null
     * */
    public function configureFormFields();

    /**
     * Configure show fields
     *
     * @return array|null
     * */
    public function configureShowFields();

    /**
     * Configure list fields
     *
     * @return array|null
     * */
    public function configureListFields();

    /**
     * Configure filter fields
     *
     * @return array|null
     * */
    public function configureFilterFields();

    /**
     * Init controller routes
     *
     * @param Router $router
     * @param string $name Entity name.
     * @param array $parameters
     *
     * @return void
     * */
    public static function routesMap(Router $router, $name, array $parameters);

}