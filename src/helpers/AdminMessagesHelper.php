<?php

/**
 * Author: Max Kovpak <max_kovpak@hotmail.com>
 * Date: 16.03.14
 * Time: 21:48
 */

class AdminMessagesHelper {
    private static $tpl = '
        <div class="alert alert-#TYPE# no-margin fade in">
            <button data-dismiss="alert" class="close">×</button>
            <i class="fa-fw fa fa-info"></i>
            #MESSAGE#
        </div>
    ';

    public static function process() {
        $messages = ViewHelper::getInstance()->getMessages();

        $html = '';
        if (count($messages)) {
            foreach ($messages as $k => $message) {
                if (is_array($message) && isset($message['type']) && isset($message['text'])) {
                    $message['text'] = trim($message['text']);
                    if(empty($message['text'])) {
                        continue;
                    }
                    $message['type'] = !empty($message['type']) ? $message['type'] : 'info';
                    $message['type'] = $message['type'] == 'error' ? 'danger' : $message['type'];
                    $tpl = self::$tpl;
                    $tpl = str_replace('#TYPE#', $message['type'], $tpl );
                    $tpl = str_replace('#MESSAGE#', $message['text'], $tpl );

                    $html .= $tpl;
                } else {
                    continue;
                }
            }
        }
        echo $html;
    }
}