<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [
    'as' => 'home',
    'uses' => 'HomeController@getHome',
]);

Route::group(['middleware' => 'email'], function() {
    Route::post('signup', [
        'as' => 'postSignup',
        'uses' => 'AuthUserController@postSignup',
    ]);
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'admin.home']);
});
