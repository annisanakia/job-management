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

Route::group(['prefix' => 'task', 'namespace' => 'App\Modules\Task\Controllers', 'middleware' => ['web','auth',AccessUser::class]], function () {
    Route::get('/', ['as' => 'task.index', 'uses' => 'Task@index']);
    Route::get('/create', ['as' => 'task.create', 'uses' => 'Task@create']);
    Route::post('/store', ['as' => 'task.store', 'uses' => 'Task@store']);
    Route::get('/edit/{id}', ['as' => 'task.edit', 'uses' => 'Task@edit']);
    Route::get('/detail/{id}', ['as' => 'task.detail', 'uses' => 'Task@detail']);
    Route::post('/update/{id}', ['as' => 'task.update', 'uses' => 'Task@update']);
    Route::post('/delete/{id}', ['as' => 'task.delete', 'uses' => 'Task@delete']);
    Route::get('/getListAsPdf', ['as' => 'task.getListAsPdf', 'uses' => 'Task@getListAsPdf']);
    Route::get('/getListAsXls', ['as' => 'task.getListAsXls', 'uses' => 'Task@getListAsXls']);
    
    Route::get('/updateCompleted/{id}', ['as' => 'task.updateCompleted', 'uses' => 'Task@updateCompleted']);
    Route::get('/updateFlag/{id}', ['as' => 'task.updateFlag', 'uses' => 'Task@updateFlag']);
    Route::get('/getSLA', ['as' => 'task.getSLA', 'uses' => 'Task@getSLA']);
    Route::get('/setDuration', ['as' => 'task.setDuration', 'uses' => 'Task@setDuration']);
});