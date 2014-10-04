<?php
if(isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/admin')===0) {
        Route::group(array('prefix' => 'admin'), function () {
        Route::pattern('id', '[0-9]+');
        Route::pattern('page_number', '[0-9]+');
        Route::any('/save_order_elements', 'SmallTeam\Admin\AdminBaseController@anySaveOrderElements');
        Route::any('/upload_file', 'SmallTeam\Admin\AdminBaseController@anyUploadFile');
        Route::any('/upload_files', 'SmallTeam\Admin\AdminBaseController@anyUploadFiles');
    //    Route::any('/{module}/delete_file.json', 'AdminBaseController@anyDeleteFile');

        if(isset($_SERVER['REQUEST_URI'])) {
            $uri = str_replace(array('/admin', '?'.$_SERVER['QUERY_STRING']), '', $_SERVER['REQUEST_URI']);
            $uri = str_replace('//', '/', '/'.$uri.'/');
            $patterns = array(
                '#^/(?P<controller>[-_a-z0-9]+)/page/(?P<current_page>[0-9]+)/?$#isU',
                '#^/(?P<controller>[-_a-z0-9]+)/(?P<action>[-_a-z]+)/(?P<id>[0-9]+)/?$#isU',
                '#^/(?P<controller>[-_a-z0-9]+)/(?P<action>[-_a-z]+)/?$#isU',
                '#^/(?P<controller>[-_a-z0-9]+)/?$#isU',
            );
            $result = null;
            foreach ($patterns as $pattern) {
                preg_match($pattern, $uri, $result);
                if(is_array($result) && !empty($result)) {
                    break;
                }
            }

            $controller = isset($result['controller']) && !empty($result['controller']) ? ucfirst(SmallTeam\Admin\StringTools::functionalize($result['controller'])) : false;
            $action = isset($result['action']) && !empty($result['action']) ? ucfirst(SmallTeam\Admin\StringTools::functionalize($result['action'])) : false;
            $current_page = isset($result['current_page']) && intval($result['current_page']) ? intval($result['current_page']) : false;
            if($controller && $action) {
                Route::any(strtolower($result['controller']).'/'.strtolower($result['action']), $controller.'Controller' . '@any' . $action);
                Route::any(strtolower($result['controller']).'/'.strtolower($result['action']).'/{id}', $controller.'Controller' . '@any' . $action);
            } elseif($controller && class_exists($controller.'Controller') && !$current_page) {
                Route::any(strtolower($result['controller']), $controller.'Controller@anyIndex');
                Route::controller(strtolower($result['controller']), $controller.'Controller');
            } elseif($controller && class_exists($controller.'Controller') && $current_page) {
                Route::controller(strtolower($result['controller']).'/page/{page_number}', $controller.'Controller');
            }
        }

        Route::controller('/', 'SmallTeam\Admin\AdminIndexController');
    });
}