<?php

class Debug {

    /**
     * using to simplify debug echo.
     *
     * @param mixed, mixed.. All variables to dump.
     * If last parametr == '!@#' - No die after dumping.
     *
     * @return void
     */
    public static function vd() {
        $arguments = func_get_args();
        if (count($arguments)) {
            if (!empty($_SERVER['DOCUMENT_ROOT'])) {
                if(!headers_sent()) {
                    header('Content-Type: text/html; charset=utf-8');
                }
                echo '<pre>';
            }
            $last = array_pop($arguments);
            foreach($arguments as $item) echo self::dumperGet($item) . "\n";
            if ($last !== '!@#') {
//            var_dump($last);
                echo self::dumperGet($last);
                die();
            }
            if (!empty($_SERVER['DOCUMENT_ROOT'])) {
                echo '</pre>';
            } else echo "\n";
        }
    }

    public static function dumpAsString($var, $new_level = 0) {
        $res = '';

        if (is_bool($var)) {
            $res = $var ? "true" : "false";
        } elseif(is_null($var)) {
            $res = "null";
        } elseif(is_array($var)) {
            $res = 'array (';

            foreach($var as $key=>$item) {
                $res .= "\n". str_repeat(" ", ($new_level+1)*4);
                $res .= self::dumpAsString($key, $new_level+1);
                $res .= ' => ';
                $res .= self::dumpAsString($item, $new_level+1).',';
            }

            $res .= "\n".str_repeat(" ", ($new_level)*4).')';
        } elseif(is_string($var) && (isset($var[0]) && $var[0] != '$')) {
            $res = '"'.str_replace('"', '\"', $var).'"';
        } else {
            $res = $var;
        }

        return $res;
    }


    public static function recurse($array, $array1) {
        foreach ($array1 as $key => $value) {
            // create new key in $array, if it is empty or not an array
            if (!isset($array[$key]) || (isset($array[$key]) && !is_array($array[$key]))) {
                $array[$key] = array();
            }

            // overwrite the value in the base array
            if (is_array($value)) {
                $value = self::recurse($array[$key], $value);
            }
            $array[$key] = $value;
        }
        return $array;
    }

    public static function array_replace_recursive() {
        // handle the arguments, merge one by one
        $args = func_get_args();
        $array = $args[0];
        if (!is_array($array)) {
            return $array;
        }
        for ($i = 1; $i < count($args); $i++) {
            if (is_array($args[$i])) {
                $array = self::recurse($array, $args[$i]);
            }
        }
        return $array;
    }



    public static function dumperGet(&$obj, $leftSp = "", $showDebugTootls = false ) {
        if( is_array( $obj ) ) {
            $type = "Array[" . count( $obj ) . "]";
        } elseif( is_object( $obj ) ) {
            $type = "Object";
        } elseif( gettype( $obj ) == "boolean" ) {
            return $obj ? "true" : "false";
        } elseif( is_null( $obj ) ) {
            return "NULL";
        } else {
            ob_start();
            var_dump($obj);
            return ob_get_clean();
        }
        $buf = $type;
        $leftSp .= "    ";
        for (reset( $obj ); list ( $k, $v ) = each( $obj );) {
            if ($k === "GLOBALS" )
                continue;
            $buf .= "\n".$leftSp.'['.$k.'] => ' . self::dumperGet( $v, $leftSp, $showDebugTootls );
        }

        return $buf;
    }
}