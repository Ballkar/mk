<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1'], function () {

    Route::group(['middleware' => ['auth:api']], function () {
        Route::group(['middleware' => ['auth:api'], 'namespace' => 'Admin'], function () {
            Route::post('admin/wallet', 'WalletTransactionController@add');
        });

        Route::group(['namespace' => 'Calendar'], function () {
            Route::apiResource('calendar/works', 'WorksController')->except('show');
        });
        Route::group(['namespace' => 'Message'], function () {
            Route::post('messages/schemas/preview', 'SchemaController@preview');
            Route::apiResource('messages/schemas', 'SchemaController');
            Route::apiResource('messages/history', 'MessageController')->except('update', 'destroy');
            Route::apiResource('messages/plans', 'PlansController');
        });

        Route::group(['namespace' => 'User'], function () {
            Route::get('user', 'UserController@user')->name('user');
            Route::post('user', 'UserController@update')->name('user.update');
            Route::post('user/password', 'UserController@passwordChange')->name('user.passwordChange');
            Route::get('notifications/calculate', 'NotificationController@calculate');
            Route::apiResource('notifications', 'NotificationController')->only(['index', 'show', 'delete']);
        });
        Route::apiResource('customers', 'CustomerController');
    });

    Route::group(['namespace' => 'Auth'], function () {
        Route::post('login', 'LoginController@login')->name('login');
        Route::post('register', 'RegisterController@register')->name('register');
        Route::group(['middleware' => 'auth:api'], function() {
            Route::post('logout', 'LoginController@logout')->name('logout');
        });
    });
});
