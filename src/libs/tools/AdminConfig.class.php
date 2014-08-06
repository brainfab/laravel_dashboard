<?php
class AdminConfig {
    protected static $_config = null;

    protected function __construct() {}

    public static function getConfig($what = null) {
        self::loadConfigs();
        if($what) {
            if(is_array(self::$_config) && array_key_exists($what, self::$_config)) {
                return self::$_config[$what];
            }
            return null;
        } else {
            return self::$_config;
        }
    }

    public static function getConfigPath() {
        return dirname(__FILE__).'/../config/config.yml';
    }

    protected static function loadConfigs() {
        if(is_null(self::$_config)) {
            $config_path = dirname(__FILE__).'/../config/config.yml';
            self::$_config = is_file($config_path) ? sfYaml::load($config_path) : array();
        }
    }

    public static function getDirUpload() {
        $upload_path = self::getConfig('upload_path');
        $upload_path = $upload_path && !empty($upload_path) ? $upload_path : 'upload';
        return public_path() . '/'.$upload_path .'/';
    }
}