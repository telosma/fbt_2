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

Route::get('/', function() {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'admin.home']);
});

Route::match(['get', 'post'], 'upload/image/ckeditor', [
    'uses' => 'UploadController@storageImageCKEditor',
    'as' => 'upload.image.CKEditor'
]);
Route::post('upload/image', ['uses' => 'UploadController@storageImage', 'as' => 'upload.image']);
