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

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('me', 'UserController@getMe');

Route::get('/', 'TaskController@index');

Route::post('task', 'TaskController@store');
Route::get('tasks', 'TaskController@getTasks');
Route::patch('task/{id}', 'TaskController@update');
Route::patch('task/change-status/{id}', 'TaskController@changeStatus');
Route::delete('task/{id}', 'TaskController@destroy');
