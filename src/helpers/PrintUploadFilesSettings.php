<?php

class PrintUploadFilesSettings {
    /*
      * $params[0] - model
      * $params[1] - id
      * $params[2] - module
      * $params[3] - field name
      * */
    public static function process() {
        $params = func_get_args();

        $model = isset($params[0]) ? $params[0] : '';
        $id = isset($params[1]) ? $params[1] : '';
        $module = isset($params[2]) ? $params[2] : '';
        $name = isset($params[3]) ? $params[3] : '';
        $multiple = isset($params[4]) && $params[4] ? 1 : 0;
        $action = isset($params[5]) ? $params[5] : 'upload_files';

        $res = '{';
        $res .= 'model: \''.$model.'\',';
        $res .= 'id: '.$id.',';
        $res .= 'module: \''.$module.'\',';
        $res .= 'name: \''.$name.'\',';
        $res .= 'multiple: '.$multiple.',';
        $res .= 'action: \''.$action.'\'';
        $res .= '}';

        echo $res;
    }
}