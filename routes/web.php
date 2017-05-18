<?php

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
	Route::delete('/user/{id}', 'UserController@delete');
	Route::get('/user', ['uses' => 'AdminController@user', 'as' => 'admin.user']);
	Route::post('/user/create', ['uses' => 'UserController@create', 'as' => 'admin.user.create']);

	Route::get('/', 'AdminController@index');
});

// group này chỉ hiển thị khi user đã được đăng nhập vào hệ thống
// name(tên) nào mà không có từ get ở đầu nghĩa là chỉ lấy trang view
Route::group(['prefix' => 'facebook', 'middleware' => 'auth'], function () {
	Route::group(['namespace' => 'Facebook', 'prefix' => 'friends'], function () {
		Route::get('/{uid?}/{idUnfriend?}', 'FriendsController@friends')->where(['id' => '[0-9]+', 'idUnfriend' => '[0-9]+'])->name('fb.friends');
		Route::post('{uid}/ufl', 'FriendsController@unfriend_from_list')->name('fb.ufl'); // ufl <=> unfriend_from_list
	});

	Route::group(['namespace' => 'Facebook', 'prefix' => 'status'], function () {
		Route::get('/{uid?}', 'WallController@getStatus')->name('fb.stt')->where('uid', '[0-9]+');
		Route::post('/{uid}/lmp', 'WallController@Ajax_LoadMorePost')->name('fb.stt.lmp')->where('uid', '[0-9]+'); // lmp <=> load more post
		Route::get('/poststatus/{uid?}', 'WallController@postStatus')->name('fb.stt.poststt')->where('uid', '[0-9]+');
	});

	Route::group(['namespace' => 'Facebook', 'prefix' => 'group'], function () {
		Route::get('/group', 'HomeController@group');
		Route::post('/group', 'FacebookController@postGroup');
	});

	Route::post('/login', ['uses' => 'SocialController@login_facebook', 'as' => 'fb.login']);
});

Route::get('/', ['uses' => 'HomeController@index', 'as' => 'index']);
Route::get('/home', ['uses' => 'HomeController@index', 'as' => 'index']);

Route::get('/logout', 'Auth\LoginController@logout');

Auth::routes();
