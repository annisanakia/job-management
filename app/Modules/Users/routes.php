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

Route::group(['prefix' => 'users', 'namespace' => 'App\Modules\Users\Controllers', 'middleware' => ['web','auth',AccessUser::class]], function () {
    Route::get('/', ['as' => 'users.index', 'uses' => 'Users@index']);
    Route::get('/create', ['as' => 'users.create', 'uses' => 'Users@create']);
    Route::post('/store', ['as' => 'users.store', 'uses' => 'Users@store']);
    Route::get('/edit/{id}', ['as' => 'users.edit', 'uses' => 'Users@edit']);
    Route::get('/detail/{id}', ['as' => 'users.detail', 'uses' => 'Users@detail']);
    Route::post('/update/{id}', ['as' => 'users.update', 'uses' => 'Users@update']);
    Route::post('/delete/{id}', ['as' => 'users.delete', 'uses' => 'Users@delete']);
    Route::get('/getListAsPdf', ['as' => 'users.getListAsPdf', 'uses' => 'Users@getListAsPdf']);
    Route::get('/getListAsXls', ['as' => 'users.getListAsXls', 'uses' => 'Users@getListAsXls']);
});