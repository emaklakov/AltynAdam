<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes V1
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
	Route::post('login','AuthController@login');
	Route::post('signup','AuthController@signup');

	Route::group(['middleware' => 'auth:sanctum'], function () {
		Route::get('logout','AuthController@logout');
		Route::get('user','AuthController@user');
	});
});

Route::middleware('auth:sanctum')->group(function() {
	Route::group(['middleware' => 'role:administrator'], function() {
		Route::get('/users/{user_id}', 'UserController@show'); // Информация о пользователе

		Route::put('/users/{user_id}/block', 'UserController@block'); // Блокировка/разблокировка пользователя
		Route::put('/users/{user_id}/roles', 'UserController@roles');
		Route::put('/users/{user_id}/permissions', 'UserController@permissions');
	});

	Route::group(['middleware' => 'role:manager', 'permission:manage-ovoschi'], function() {

	});
});
