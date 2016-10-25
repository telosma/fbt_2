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

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'admin.home']);
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', ['uses' => 'CategoryController@index', 'as' => 'admin.category.index']);
        Route::group(['prefix' => 'ajax'], function () {
            Route::get('list', ['uses' => 'CategoryController@ajaxList', 'as' => 'admin.category.ajax.list']);
            Route::post('create', ['uses' => 'CategoryController@ajaxCreate', 'as' => 'admin.category.ajax.create']);
            Route::post('update', ['uses' => 'CategoryController@ajaxUpdate', 'as' => 'admin.category.ajax.update']);
            Route::delete('delete', ['uses' => 'CategoryController@ajaxDelete', 'as' => 'admin.category.ajax.delete']);
            Route::get('list-only', ['uses' => 'CategoryController@ajaxListOnly', 'as' => 'admin.category.ajax.listOnly']);
        });
    });
});

Route::match(['get', 'post'], 'upload/image/ckeditor', [
    'uses' => 'UploadController@storageImageCKEditor',
    'as' => 'upload.image.CKEditor'
]);
Route::post('upload/image', ['uses' => 'UploadController@storageImage', 'as' => 'upload.image']);
