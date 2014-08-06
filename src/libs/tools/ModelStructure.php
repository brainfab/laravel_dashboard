<?php

class ModelStructure {

    /**
     * @description Build model structure by DB table
     * @param string $model Model name
     * @return array
     * */
    public static function getStructure($model) {
        /* @var Eloquent $obj */
        $obj = new $model();
        $table = $obj->getTable();
        $structure = DB::select('DESCRIBE '.  $table .'');
        $result = array();

        if(is_array($structure) && !empty($structure)) {
            $columns = array();
            foreach ($structure as $item) {
                $columns[$item->Field] = array(
                    'type' => $item->Type,
                    'default' => $item->Default,
                    'not_null' => $item->Null == 'NO' ? true : false,
                );
            }

            $result = array(
                'table' => $table,
                'primary_key' => $obj->getKeyName(),
                'columns' => $columns,
            );
        }
        return $result;
    }
}