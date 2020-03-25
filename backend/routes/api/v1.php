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
	Route::group(['middleware' => 'role:administrator,manage-users'], function() {
		/* Работа с пользователями */
		Route::get('/users', 'UserController@index');
		Route::get('/users/{user_id}', 'UserController@show'); // Информация о пользователе
		Route::post('/users', 'UserController@store');
		Route::put('/users/{user_id}', 'UserController@update');

		Route::put('/users/{user_id}/block', 'UserController@block'); // Блокировка/разблокировка пользователя
		Route::put('/users/{user_id}/roles', 'UserController@roles'); // Поли пользователя
		Route::put('/users/{user_id}/permissions', 'UserController@permissions'); // Права пользователя
	});

	Route::group(['middleware' => 'role:administrator,manage-roles'], function() {
		Route::group(['prefix' => 'dictionaries'], function () {
			/* Работа с ролями */
			Route::get('/roles','Dictionaries\RoleController@index');
			Route::post('/roles','Dictionaries\RoleController@store');
			Route::get('/roles/{role_id}','Dictionaries\RoleController@show');
			Route::put('/roles/{role_id}','Dictionaries\RoleController@update');
			Route::delete('/roles/{role_id}','Dictionaries\RoleController@destroy');
		});
	});

	Route::group(['middleware' => 'role:administrator,manage-roles'], function() {
		Route::group(['prefix' => 'dictionaries'], function () {
			/* Работа с правами */
			Route::get('/permissions','Dictionaries\PermissionController@index');
			Route::post('/permissions','Dictionaries\PermissionController@store');
			Route::get('/permissions/{permission_id}','Dictionaries\PermissionController@show');
			Route::put('/permissions/{permission_id}','Dictionaries\PermissionController@update');
			Route::delete('/permissions/{permission_id}','Dictionaries\PermissionController@destroy');
		});
	});

	Route::group(['middleware' => 'role:manager,manage-ovoschi'], function() {

	});
});
