<?php

use Illuminate\Http\Request;


Route::group(['middleware' => ['displayChinese', 'cors']], function () {

    Route::post('login', 'UserController@login');
    Route::post('register', 'UserController@register');
    Route::get('gePtt', 'MessageController@gePtt');

    Route::group(['middleware' => 'jwt_auth'], function () {
        Route::get('getMessage', 'MessageController@getMessage');
        Route::post('sendMessage', 'MessageController@sendMessage');
        Route::post('deleteMessage', 'MessageController@deleteMessage');
    });
});

