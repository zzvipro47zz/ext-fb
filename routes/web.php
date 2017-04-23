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

	Route::get('/friend', ['uses' => 'FacebookController@friend', 'as' => 'fb.getFriend']);

	Route::get('/postwall', ['uses' => 'Facebook\WallController@getWall', 'as' => 'fb.getWall']);
	Route::post('/postwall', ['uses' => 'Facebook\WallController@postWall', 'as' => 'fb.postWall']);

	Route::get('/postgroup', ['uses' => 'FacebookController@postgroup', 'as' => 'fb.getGroup']);
	Route::post('/postgroup', ['uses' => 'FacebookController@postgroup', 'as' => 'fb.postGroup']);
});


Route::get('/logout' , 'Auth\LoginController@logout');

Route::get('/', ['uses' => 'HomeController@index', 'as' => 'index']);