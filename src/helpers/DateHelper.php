<?php

class DateHelper {
    public static function process() {
        $params = func_get_args();
        if (isset($params[0])) {
            $date = $params[0];
            $date = strtotime($date);
        } else {
            $date = date('d/m/Y');
            return $date;
        }
        if ($date) {
            $res = date(!empty($params[1]) ? trim($params[1],'\'"') : "d/m/Y H:i s", $date);
            if ($res[0] == '"') $res = substr($res, 1, -1);

            $en = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
            $ru = array('Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');

            $res = str_replace($en, $ru, $res);
            return $res;
        } else {
            return '';
        }
    }
}