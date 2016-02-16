<?php namespace SmallTeam\Dashboard;

use SmallTeam\Dashboard\Entity\EntityInterface;

/**
 * DashboardInterface
 *
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @url www.max-kovpak.com
 * @date 09.05.2015
 * */
interface DashboardInterface
{
    /**
     * Detect current dashboard
     * and init dashboard application
     *
     * @throws \RuntimeException
     * @return void
     * */
    public function boot();

    /**
     * Get dashboard config
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     * */
    public function get($key = null, $default = null);

    /**
     * Set dashboard config
     *
     * @param string $key
     * @param mixed $value
     * @return DashboardInterface
     * */
    public function set($key, $value);

    /**
     * Get dashboard name
     *
     * @return string
     * */
    public function getName();

    /**
     * Get dashboard short name
     *
     * @return string
     * */
    public function getShortName();

    /**
     * Get dashboard alias
     *
     * @return string
     * */
    public function getAlias();

    /**
     * Get dashboard prefix
     *
     * @return string
     * */
    public function getPrefix();

    /**
     * Generate a url for the dashboard.
     *
     * @param  string  $path
     * @param  mixed   $parameters
     * @param  bool    $secure
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function url($path = null, $parameters = [], $secure = null);

    /**
     * Get dashboard entity
     *
     * @return EntityInterface
     * */
    public function getEntity();

    /**
     * Set current locale
     *
     * @param string $locale
     * @return void
     * */
    public function setCurrentLocale($locale);

    /**
     * Get active locale
     *
     * @return EntityInterface
     * */
    public function getCurrentLocale();

    /**
     * Get all locales
     *
     * @return EntityInterface
     * */
    public function getLocales();

}