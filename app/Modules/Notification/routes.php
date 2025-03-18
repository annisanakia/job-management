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
use App\Http\Middleware\AccessUser;

Route::group(['prefix' => 'notification', 'namespace' => 'App\Modules\Notification\Controllers', 'middleware' => ['web','auth',AccessUser::class]], function () {
    Route::get('/', ['as' => 'notification.index', 'uses' => 'Notification@index']);
    Route::get('/notificationNewList', ['as' => 'notification.notificationNewList', 'uses' => 'Notification@notificationNewList']);
    Route::get('/notificationDetail/{id}', ['as' => 'notification.notificationDetail', 'uses' => 'Notification@notificationDetail']);
    Route::get('/markAllRead', ['as' => 'notification.markAllRead', 'uses' => 'Notification@markAllRead']);
});