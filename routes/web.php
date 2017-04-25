<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
	Route::delete('/user/{id}', 'UserController@delete');
	Route::get('/user', ['uses' => 'AdminController@user', 'as' => 'admin.user']);
	Route::post('/user/create', ['uses' => 'UserController@create', 'as' => 'admin.user.create']);

	Route::get('/', 'AdminController@index');
});

Route::group(['prefix' => 'facebook'], function() {
	Route::get('redirect', ['uses' => 'SocialController@redirectToProvider', 'as' => 'fb.redirect']);
	Route::get('callback', ['uses' => 'SocialController@handleProviderCallback', 'as' => 'fb.callback']);
	// end

	Route::get('/unfriend', 'HomeController@unfriend');
	Route::get('/addfriend', 'HomeController@addfriend');

	Route::get('wall', 'HomeController@Wall');
	Route::post('wall', 'Facebook\WallController@postWall');

	Route::get('/group', 'HomeController@group');
	Route::post('/group', 'FacebookController@postGroup');
});


Route::get('/logout' , 'Auth\LoginController@logout');

Route::get('/', ['uses' => 'HomeController@index', 'as' => 'index']);
Route::get('/dashboard', ['uses' => 'HomeController@index', 'as' => 'index']);
