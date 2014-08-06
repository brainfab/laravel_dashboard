<?php

class ArrayTools {
    static public function getDeepArrayValue($array, $what = null) {
        if ($what !== null) {
            $what = explode('/', $what);
            foreach($what as $key) {
                if (! isset($array[$key])) return null;

                $array = $array[$key];
            }
        }

        return $array;
    }

    static public function setDeepArrayValue(&$array, $value, $what = null) {
        $set_to = &$array;
        if ($what) {
            $what = explode('/', $what);
            foreach($what as $key) {
                if (!array_key_exists($key, $set_to)) $set_to[$key] = null;

                $set_to = &$set_to[$key];
            }
        }
        $set_to = $value;
    }

    static public function unsetDeepArrayValue(&$array, $what = null) {
        $deep = &$array;
        if ($what) {
            $what = explode('/', $what);
            foreach($what as $i => $key) {
                if (!array_key_exists($key, $deep)) break;
                if ($i == count($what) -1) {
                    unset($deep[$key]);
                } else {
                    $deep = &$deep[$key];
                }
            }
        }
    }

    static public function extendDeepArrayValue(&$handle, $exnteder) {
        foreach($exnteder as $key=>$value) {
            if (!array_key_exists($key, $handle)) {
                $handle[$key] = $value;
                continue;
            }
            if (is_array($value)) {
                self::extendDeepArrayValue($handle[$key], $value);
            } else {
                $handle[$key] = $value;
            }
        }
    }

    public static function useValue($array, $key) {
        $res = array();
        foreach ($array as $item) {
            if(is_object($item)) {
                $res[] = $item->{$key};
            } else if (is_array($item)) {
                $res[] = $item[$key];
            }
        }
        return $res;
    }
}