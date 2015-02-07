<?php

Route::group(['namespace' => 'SmallTeam\Dashboard\App\Http\Controllers', 'prefix' => config('dashboard.prefix')], function()
{
    Route::get('/', 'IndexController@index');
});

