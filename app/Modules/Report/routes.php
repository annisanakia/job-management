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

Route::group(['prefix' => 'report', 'namespace' => 'App\Modules\Report\Controllers', 'middleware' => ['web','auth',AccessUser::class]], function () {
    Route::get('/', ['as' => 'report.index', 'uses' => 'Report@index']);
    Route::get('/getReport', ['as' => 'report.getReport', 'uses' => 'Report@getReport']);
    Route::get('/getListAsPdf', ['as' => 'report.getListAsPdf', 'uses' => 'Report@getListAsPdf']);
    Route::get('/getListAsXls', ['as' => 'report.getListAsXls', 'uses' => 'Report@getListAsXls']);
});