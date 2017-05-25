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
		Route::get('/{uid?}', 'FriendsController@getFriends')->where('uid', '[0-9]+')->name('fb.getfriends');
		Route::post('/{uid}/lmf', 'FriendsController@Ajax_LoadMoreFriends')->where('uid', '[0-9]+')->name('fb.lmf');
		Route::get('/{uid}/{idFriend}', 'FriendsController@unfriend')->where(['uid' => '[0-9]+', 'idFriend' => '[0-9]+'])->name('fb.unfriend');
		Route::post('{uid}/ufl', 'FriendsController@unfriend_from_list')->name('fb.ufl'); // ufl <=> unfriend_from_list
	});

	Route::group(['namespace' => 'Facebook', 'prefix' => 'status'], function () {
		Route::get('/{uid?}', 'WallController@getStatus')->name('fb.stt.getstt')->where('uid', '[0-9]+');
		Route::post('/{uid}/lmp', 'WallController@Ajax_LoadMorePost')->name('fb.stt.lmp')->where('uid', '[0-9]+'); // lmp <=> load more post
		Route::get('/delstt/{uid}/{idStatus}', 'WallController@deleteStatus')->name('fb.delstt');
		Route::get('/poststatus', 'WallController@postStatus')->name('fb.stt.poststt');
		Route::post('/poststatus', 'WallController@postStatus');
	});

	Route::group(['namespace' => 'Facebook', 'prefix' => 'group'], function () {
		Route::get('/group', 'HomeController@group');
		Route::post('/group', 'FacebookController@postGroup');
	});

	Route::post('/login', ['uses' => 'SocialController@login_facebook', 'as' => 'fb.login']);
});

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::get('/logout', 'Auth\LoginController@logout');

Auth::routes();
Route::get('test', 'Facebook\WallController@itsTimeToPostStt');