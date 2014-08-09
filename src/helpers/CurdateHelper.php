<?php
namespace SmallTeam\Admin;

class CurdateHelper {
    public static function process($format = 'd-m-Y H:i:s') {
        return date($format);
    }
}