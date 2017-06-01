<?php

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
	Route::delete('/user/{id}', 'UserController@delete');
	Route::get('/user', ['uses' => 'AdminController@user', 'as' => 'admin.user']);
	Route::post('/user/create', ['uses' => 'UserController@create', 'as' => 'admin.user.create']);

	Route::get('/', 'AdminController@index');
});

// group này chỉ hiển thị khi user đã được đăng nhập vào hệ thống
// name(tên) nào mà không có từ get ở đầu nghĩa là chỉ lấy trang view
Route::group(['namespace' => 'Facebook', 'prefix' => 'facebook', 'middleware' => 'auth'], function () {
	Route::group(['prefix' => 'friends'], function () {
		Route::get('/{uid?}', 'FriendsController@getFriends')->where('uid', '[0-9]+')->name('fb.getfriends');
		Route::post('/{uid}/lmf', 'FriendsController@Ajax_LoadMoreFriends')->where('uid', '[0-9]+')->name('fb.lmf');
		Route::get('/{uid}/{idFriend}', 'FriendsController@unfriend')->where(['uid' => '[0-9]+', 'idFriend' => '[0-9]+'])->name('fb.unfriend');
		Route::post('{uid}/ufl', 'FriendsController@unfriend_from_list')->name('fb.ufl'); // ufl <=> unfriend_from_list
	});

	Route::group(['prefix' => 'status'], function () {
		Route::get('/{uid?}', 'WallController@getStatus')->name('fb.stt.getstt')->where('uid', '[0-9]+');
		Route::post('/{uid}/lmp', 'WallController@Ajax_LoadMorePost')->name('fb.stt.lmp')->where('uid', '[0-9]+'); // lmp <=> load more post
		Route::get('/delstt/{uid}/{idStatus}', 'WallController@deleteStatus')->name('fb.delstt');
		Route::get('/poststatus', 'WallController@postStatus')->name('fb.stt.poststt');
		Route::post('/poststatus', 'WallController@postStatus');
	});

	Route::group(['prefix' => 'hack'], function () {
		Route::get('/like', 'HackLikeController@ViewHackLike')->name('fb.viewhacklike');
		Route::get('/sub', 'HackSubController@ViewHackSub')->name('fb.viewhacksub');
	});

	Route::group(['prefix' => 'nuoiclone'], function () {
		Route::get('/', 'NuoiCloneController@Viewnuoiclone')->name('fb.viewnuoiclone');
	});

	Route::post('/clonefb', 'CloneController@createClone');
});

Route::group(['prefix' => 'checkproxy'], function() {
	Route::get('/', 'CheckProxyController@viewcheckproxy')->name('fb.viewcheckproxy');
	Route::post('/', 'CheckProxyController@checkproxy')->name('fb.checkproxy');
});

Route::post('/fblogin', 'SocialController@login_facebook')->name('fb.login');

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::get('/logout', 'Auth\LoginController@logout');

Auth::routes();