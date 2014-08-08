<?php
namespace SmallTeam\Admin;

/**
 * @author Max Kovpak <max_kovpak@hotmail.com>
 * @copyright SmallTeam (c) 2014
 */

Class Image {
    static protected $instance = null;

    static private $_engines        = array();

    /** @var GDImageEngine|IMagickImageEngine self::$_active_engine */
    static private $_active_engine  = null;

    protected function __construct() {

    }

    public static function getInstance() {
        if(is_null(self::$instance)) {
            self::initialize();
        }
        return self::$instance;
    }

    static protected function initialize() {
        if(is_null(self::$instance)) {
            self::$instance = new self();

            $engine = AdminConfig::getConfig('image_engine');
            $engine = $engine && in_array($engine, array('GD', 'IMagick')) ? $engine : 'GD';
            $engine_class = 'SmallTeam\Admin\\'.$engine.'ImageEngine';
            self::$_engines[$engine] = new $engine_class;
            self::$_active_engine = self::$_engines[$engine];
        }
    }

    public function fitIn($source, $destination, $dimensions, $gravity = 'center') {
        self::$_active_engine->fitIn($source, $destination, $dimensions, $gravity);
    }

    public function fitOut($source, $destination, $dimensions, $gravity = 'center') {
        self::$_active_engine->fitOut($source, $destination, $dimensions, $gravity);
    }

    public function fitInFull($source, $destination, $dimensions, $gravity = 'center', $additional_process = array()) {
        self::$_active_engine->fitInFull($source, $destination, $dimensions, $gravity, $additional_process);
    }

    public function fitInBigger($source, $destination, $dimensions, $gravity = 'center') {
        self::$_active_engine->fitInBigger($source, $destination, $dimensions, $gravity);
    }
    public function fitOutBigger($source, $destination, $dimensions, $gravity = 'center') {
        self::$_active_engine->fitOutBigger($source, $destination, $dimensions, $gravity);
    }

    public function fitInWCondition($source, $destination, $dimensions, $gravity = 'center') {
        self::$_active_engine->fitInWCondition($source, $destination, $dimensions, $gravity);
    }

    public function performCarouselPic($source, $destination, $dimensions, $gravity = 'center') {
        self::$_active_engine->performCarouselPic($source, $destination, $dimensions, $gravity);
    }

    public function getImageInfo($path) {
        return self::$_active_engine->getImageInfo($path);
    }
}