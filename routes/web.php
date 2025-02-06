<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AccessUser;

Route::get('/', ['uses' => '\App\Modules\Home\Controllers\Home@index'])->middleware('auth',AccessUser::class);