<?php

class CurdateHelper {
    public static function process($format = 'd-m-Y H:i:s') {
        echo date($format);
    }
}