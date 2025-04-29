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

Route::group(['prefix' => 'task_reference', 'namespace' => 'App\Modules\Task_reference\Controllers', 'middleware' => ['web','auth',AccessUser::class]], function () {
    Route::get('/', ['as' => 'task_reference.index', 'uses' => 'Task_reference@index']);
    Route::get('/create', ['as' => 'task_reference.create', 'uses' => 'Task_reference@create']);
    Route::post('/store', ['as' => 'task_reference.store', 'uses' => 'Task_reference@store']);
    Route::get('/edit/{id}', ['as' => 'task_reference.edit', 'uses' => 'Task_reference@edit']);
    Route::post('/update/{id}', ['as' => 'task_reference.update', 'uses' => 'Task_reference@update']);
    Route::post('/delete/{id}', ['as' => 'task_reference.delete', 'uses' => 'Task_reference@delete']);
    Route::get('/getListAsPdf', ['as' => 'task_reference.getListAsPdf', 'uses' => 'Task_reference@getListAsPdf']);
    Route::get('/getListAsXls', ['as' => 'task_reference.getListAsXls', 'uses' => 'Task_reference@getListAsXls']);
});