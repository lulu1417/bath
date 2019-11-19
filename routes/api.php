<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('shower','ShowerController@login');
Route::post('shower','ShowerController@in');
Route::post('shower','ShowerController@out');
Route::gett('drink','DrinkController@index');
Route::post('drink','DrinkController@buy');

