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

Route::group(['prefix' => 'home', 'namespace' => 'App\Modules\Home\Controllers', 'middleware' => ['web','auth',AccessUser::class]], function () {
    Route::get('/', ['as' => 'home.index', 'uses' => 'Home@index']);
});