<?php
$namespace = config('dashboard.controllers_namespace');
$prefix = config('dashboard.prefix');

Route::group(['namespace' => $namespace, 'prefix' => $prefix], function()
{
    $namespace = config('dashboard.controllers_namespace');
    $prefix = config('dashboard.prefix');

    Route::pattern('id', '[0-9]+');
    Route::pattern('page_number', '[0-9]+');

    if(isset($_SERVER['REQUEST_URI'])) {
        $uri = str_replace(array('/'.$prefix, '?'.$_SERVER['QUERY_STRING']), '', $_SERVER['REQUEST_URI']);
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

        $controller = isset($result['controller']) && !empty($result['controller']) ? ucfirst(camel_case($result['controller'])) : false;
        $action = isset($result['action']) && !empty($result['action']) ? ucfirst(camel_case($result['action'])) : false;
        $current_page = isset($result['current_page']) && intval($result['current_page']) ? intval($result['current_page']) : false;

        if($controller && $action) {
            if(class_exists($namespace.'\\'.$controller.'Controller')) {
                Route::any(strtolower($result['controller']).'/'.strtolower($result['action']), $controller.'Controller@any'.$action);
                Route::any(strtolower($result['controller']).'/'.strtolower($result['action']).'/{id}', $controller.'Controller@any'.$action);
            }

            if(class_exists($namespace.'\Modules\\'.$controller.'Controller')) {
                Route::any(strtolower($result['controller']).'/'.strtolower($result['action']), 'Modules\\'.$controller.'Controller@any'.$action);
                Route::any(strtolower($result['controller']).'/'.strtolower($result['action']).'/{id}', 'Modules\\'.$controller.'Controller@any'.$action);
            }
        } elseif($controller && !$current_page) {
            if(class_exists($namespace.'\\'.$controller.'Controller')) {
                Route::controller(strtolower($result['controller']), $controller.'Controller');
            }

            if(class_exists($namespace.'\Modules\\'.$controller.'Controller')) {
                Route::controller(strtolower($result['controller']), 'Modules\\'.$controller.'Controller');
            }
        } elseif($controller && $current_page) {
            if(class_exists($namespace.'\\'.$controller.'Controller')) {
                Route::controller(strtolower($result['controller']).'/page/{page_number}', $controller.'Controller');
            }

            if(class_exists($namespace.'\Modules\\'.$controller.'Controller')) {
                Route::controller(strtolower($result['controller']).'/page/{page_number}', 'Modules\\'.$controller.'Controller');
            }
        }
    }

    Route::controller('/', 'IndexController');

});