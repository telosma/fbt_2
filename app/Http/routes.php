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
    Route::resource('comments', 'CommentController');
});

Route::post('signup', [
    'as' => 'signup',
    'uses' => 'AuthUserController@postSignup',
]);
Route::get('category/{id}/tours', [
    'as' => 'getTourByCategory',
    'uses' => 'HomeController@getTourByCategory',
]);
Route::get('auth/{provider}', [
    'as' => 'redirectToProvider',
    'uses' => 'AuthSocialController@redirectToProvider'
]);
Route::get('auth/{provider}/callback', 'AuthSocialController@handleProviderCallback');
Route::post('contact', ['uses' => 'HomeController@postContact', 'as' => 'postContact']);
Route::get('review/{id}', [
    'as' => 'review.show',
    'uses' => 'ReviewController@show',
]);
Route::post('ajax/tour', [
    'as' => 'ajaxGetSchedules',
    'uses' => 'TourController@postAjaxSchedules',
]);

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function() {
    Route::get('booking-cart', [
        'uses' => 'UserController@getBooking',
        'as' => 'user.booking.index',
    ]);
    Route::post('/cancel-booking', [
        'as' => 'postCancelBooking',
        'uses' => 'UserController@postCancelBooking',
    ]);
    Route::post('/booking-cart', [
        'uses' => 'UserController@postCheckout',
        'as' => 'user.checkout',
    ]);
    Route::post('/book/tour', [
        'as' => 'postBookTour',
        'uses' => 'UserController@postBookTour',
    ]);
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
    Route::get('login', ['uses' => 'AdminController@getLogin', 'as' => 'admin.getLogin']);
    Route::post('login', ['uses' => 'AdminController@postLogin', 'as' => 'admin.postLogin']);
    Route::get('logout', ['uses' => 'AdminController@logout', 'as' => 'admin.logout']);

    Route::group(['middleware' => 'admin'], function() {
        Route::get('/', ['uses' => 'HomeController@index', 'as' => 'admin.home']);

        Route::group(['prefix' => 'ajax'], function () {
            Route::get('monthly-revenue', ['uses' => 'HomeController@ajaxMonthlyRevenue', 'as' => 'admin.ajax.monthlyRevenue']);
            Route::get('annual-turnover', ['uses' => 'HomeController@ajaxAnnualTurnover', 'as' => 'admin.ajax.annualTurnover']);
        });

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
            Route::get('/', ['uses' => 'TourController@index', 'as' => 'admin.tour.index']);
            Route::group(['prefix' => 'ajax'], function () {
                Route::get('list', ['uses' => 'TourController@ajaxList', 'as' => 'admin.tour.ajax.list']);
                Route::get('show/{id}', ['uses' => 'TourController@ajaxShow', 'as' => 'admin.tour.ajax.show']);
                Route::get('show-with-schedule/{id}', [
                    'uses' => 'TourController@ajaxShowWithSchedule',
                    'as' => 'admin.tour.ajax.ajaxShowWithSchedule'
                ]);
                Route::get('list-only', ['uses' => 'TourController@ajaxListOnly', 'as' => 'admin.tour.ajax.listOnly']);
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

        Route::group(['prefix' => 'tour-schedule'], function () {
            Route::get('/', ['uses' => 'TourScheduleController@index', 'as' => 'admin.tourSchedule.index']);
            Route::group(['prefix' => 'ajax'], function () {
                Route::get('list', ['uses' => 'TourScheduleController@ajaxList', 'as' => 'admin.tourSchedule.ajax.list']);
                Route::post('create', ['uses' => 'TourScheduleController@ajaxCreate', 'as' => 'admin.tourSchedule.ajax.create']);
                Route::post('update', ['uses' => 'TourScheduleController@ajaxUpdate', 'as' => 'admin.tourSchedule.ajax.update']);
                Route::delete('delete', ['uses' => 'TourScheduleController@ajaxDelete', 'as' => 'admin.tourSchedule.ajax.delete']);
            });
        });
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', ['uses' => 'UserController@index', 'as' => 'admin.user.index']);
        Route::group(['prefix' => 'ajax'], function () {
            Route::get('list', ['uses' => 'UserController@ajaxList', 'as' => 'admin.user.ajax.list']);
            Route::post('create', ['uses' => 'UserController@ajaxCreate', 'as' => 'admin.user.ajax.create']);
            Route::post('update', ['uses' => 'UserController@ajaxUpdate', 'as' => 'admin.user.ajax.update']);
            Route::post('reset-pass', ['uses' => 'UserController@ajaxResetPass', 'as' => 'admin.user.ajax.resetPass']);
            Route::delete('delete', ['uses' => 'UserController@ajaxDelete', 'as' => 'admin.user.ajax.delete']);
        });
    });

    Route::group(['prefix' => 'booking'], function () {
        Route::get('/', ['uses' => 'BookingController@index', 'as' => 'admin.booking.index']);
        Route::group(['prefix' => 'ajax'], function () {
            Route::get('list', ['uses' => 'BookingController@ajaxList', 'as' => 'admin.booking.ajax.list']);
            Route::delete('delete', ['uses' => 'BookingController@ajaxDelete', 'as' => 'admin.booking.ajax.delete']);
            Route::post('reject', ['uses' => 'BookingController@ajaxReject', 'as' => 'admin.booking.ajax.reject']);
        });
    });
});

Route::match(['get', 'post'], 'upload/image/ckeditor', [
    'uses' => 'UploadController@storageImageCKEditor',
    'as' => 'upload.image.CKEditor'
]);
Route::post('upload/image', ['uses' => 'UploadController@storageImage', 'as' => 'upload.image']);
