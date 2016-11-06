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
Route::get('tour/{id}', [
    'uses' => 'TourController@show',
    'as' => 'getTour',
]);
Route::post('signin', [
    'as' => 'signin',
    'uses' => 'AuthUserController@postSignin',
]);

Route::group(['middleware' => 'auth'], function() {
    Route::get('signout', [
        'as' => 'signout',
        'uses' => 'AuthUserController@getSignout',
    ]);
    Route::post('tour', [
        'as' => 'postCreateReview',
        'uses' => 'ReviewController@postCreate',
    ]);
});

Route::post('signup', [
    'as' => 'signup',
    'uses' => 'AuthUserController@postSignup',
]);

Route::get('auth/{provider}', [
    'as' => 'redirectToProvider',
    'uses' => 'AuthSocialController@redirectToProvider'
]);

Route::get('auth/{provider}/callback', 'AuthSocialController@handleProviderCallback');

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

    Route::group(['prefix' => 'revenue'], function () {
        Route::get('/', ['uses' => 'RevenueController@index', 'as' => 'admin.revenue.index']);
        Route::group(['prefix' => 'ajax'], function () {
            Route::get('list', ['uses' => 'RevenueController@ajaxList', 'as' => 'admin.revenue.ajax.list']);
            Route::post('create', ['uses' => 'RevenueController@ajaxCreate', 'as' => 'admin.revenue.ajax.create']);
            Route::post('update', ['uses' => 'RevenueController@ajaxUpdate', 'as' => 'admin.revenue.ajax.update']);
            Route::delete('delete', ['uses' => 'RevenueController@ajaxDelete', 'as' => 'admin.revenue.ajax.delete']);
            Route::get('list-only', ['uses' => 'RevenueController@ajaxListOnly', 'as' => 'admin.revenue.ajax.listOnly']);
        });
    });

    Route::group(['prefix' => 'place'], function () {
        Route::get('/', ['uses' => 'PlaceController@index', 'as' => 'admin.place.index']);
        Route::group(['prefix' => 'ajax'], function () {
            Route::get('list', ['uses' => 'PlaceController@ajaxList', 'as' => 'admin.place.ajax.list']);
            Route::post('create', ['uses' => 'PlaceController@ajaxCreate', 'as' => 'admin.place.ajax.create']);
            Route::post('update', ['uses' => 'PlaceController@ajaxUpdate', 'as' => 'admin.place.ajax.update']);
            Route::delete('delete', ['uses' => 'PlaceController@ajaxDelete', 'as' => 'admin.place.ajax.delete']);
            Route::get('list-only', ['uses' => 'PlaceController@ajaxListOnly', 'as' => 'admin.place.ajax.listOnly']);
        });
    });

    Route::group(['prefix' => 'tour'], function () {
        Route::get('/', ['uses' => 'TourController@index', 'as' => 'admin.category.index']);
        Route::group(['prefix' => 'ajax'], function () {
            Route::get('list', ['uses' => 'TourController@ajaxList', 'as' => 'admin.tour.ajax.list']);
            Route::get('show/{id}', ['uses' => 'TourController@ajaxShow', 'as' => 'admin.tour.ajax.show']);
            Route::post('create', ['uses' => 'TourController@ajaxCreate', 'as' => 'admin.tour.ajax.create']);
            Route::post('update', ['uses' => 'TourController@ajaxUpdate', 'as' => 'admin.tour.ajax.update']);
            Route::delete('delete', ['uses' => 'TourController@ajaxDelete', 'as' => 'admin.tour.ajax.delete']);
            Route::post('update-image', ['uses' => 'TourController@ajaxUpdateImage', 'as' => 'admin.tour.ajax.updateImage']);
            Route::get('images/{id}', ['uses' => 'TourController@ajaxShowImage', 'as' => 'admin.tour.ajax.showImage']);
        });
    });

    Route::group(['prefix' => 'review'], function () {
        Route::get('/', ['uses' => 'ReviewController@index', 'as' => 'admin.review.index']);
        Route::group(['prefix' => 'ajax'], function () {
            Route::get('list', ['uses' => 'ReviewController@ajaxList', 'as' => 'admin.review.ajax.list']);
            Route::delete('delete', ['uses' => 'ReviewController@ajaxDelete', 'as' => 'admin.review.ajax.delete']);
        });
    });
});

Route::match(['get', 'post'], 'upload/image/ckeditor', [
    'uses' => 'UploadController@storageImageCKEditor',
    'as' => 'upload.image.CKEditor'
]);
Route::post('upload/image', ['uses' => 'UploadController@storageImage', 'as' => 'upload.image']);
