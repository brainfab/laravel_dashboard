<?php namespace SmallTeam\Dashboard;

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
    public function getConfig($key = null, $default = null);

    /**
     * Get dashboard name
     *
     * @return string
     * */
    public function getName();

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

}