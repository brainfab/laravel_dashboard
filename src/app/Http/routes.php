<?php

Route::group(['namespace' => 'SmallTeam\Dashboard\App\Http\Controllers'], function()
{
    Route::get('/admin/', 'IndexController@index');
});

