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

Route::group(['prefix' => 'employee', 'namespace' => 'App\Modules\Employee\Controllers', 'middleware' => ['web','auth',AccessUser::class]], function () {
    Route::get('/', ['as' => 'employee.index', 'uses' => 'Employee@index']);
    Route::get('/create', ['as' => 'employee.create', 'uses' => 'Employee@create']);
    Route::post('/store', ['as' => 'employee.store', 'uses' => 'Employee@store']);
    Route::get('/edit/{id}', ['as' => 'employee.edit', 'uses' => 'Employee@edit']);
    Route::get('/detail/{id}', ['as' => 'employee.detail', 'uses' => 'Employee@detail']);
    Route::post('/update/{id}', ['as' => 'employee.update', 'uses' => 'Employee@update']);
    Route::post('/delete/{id}', ['as' => 'employee.delete', 'uses' => 'Employee@delete']);
    Route::post('/delete_img/{id}', ['as' => 'employee.delete_img', 'uses' => 'Employee@delete_img']);
    Route::get('/getListAsPdf', ['as' => 'employee.getListAsPdf', 'uses' => 'Employee@getListAsPdf']);
    Route::get('/getListAsXls', ['as' => 'employee.getListAsXls', 'uses' => 'Employee@getListAsXls']);
});