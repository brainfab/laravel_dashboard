<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::group(array('prefix' => 'admin'), function () {

    Route::pattern('id', '[0-9]+');
    Route::pattern('page_number', '[0-9]+');
    Route::any('/save_order_elements', 'BaseController@anySaveOrderElements');
    Route::any('/upload_file', 'BaseController@anyUploadFile');
    Route::any('/upload_files', 'BaseController@anyUploadFiles');
//    Route::any('/{module}/delete_file.json', 'BaseController@anyDeleteFile');

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
            if(class_exists($controller.'Controller')) {
                Route::controller(strtolower($result['controller']), $controller.'Controller');
            }
        } elseif($controller && class_exists($controller.'Controller') && $current_page) {
            Route::controller(strtolower($result['controller']).'/page/{page_number}', $controller.'Controller');
        }
    }

    Route::controller('/', 'IndexController');
});