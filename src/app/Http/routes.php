<?php

Route::group(['namespace' => config('dashboard.controllers_namespace'), 'prefix' => config('dashboard.prefix')], function()
{
    Route::get('/', 'IndexController@index');
});