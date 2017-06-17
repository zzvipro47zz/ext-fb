<?php

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
	Route::delete('/user/{id}', 'UserController@delete');
	Route::get('/user', ['uses' => 'AdminController@user', 'as' => 'admin.user']);
	Route::post('/user/create', ['uses' => 'UserController@create', 'as' => 'admin.user.create']);

	Route::get('/', 'AdminController@index');
});

// group này chỉ hiển thị khi user đã được đăng nhập vào hệ thống
// name(tên) nào mà không có từ get ở đầu nghĩa là chỉ lấy trang view
Route::group(['namespace' => 'Facebook', 'prefix' => 'facebook', 'middleware' => ['auth', 'fb']], function () {
	Route::group(['prefix' => 'friends'], function () {
		Route::get('/{uid?}', 'FriendsController@viewgetfriends')->where('uid', '[0-9]+')->name('fb.viewgetfriends');
		Route::post('/{uid}/lmf', 'FriendsController@Ajax_LoadMoreFriends')->where('uid', '[0-9]+')->name('fb.lmf');
		Route::get('/{uid}/unf/{idFriend}', 'FriendsController@unfriend')->where(['uid' => '[0-9]+', 'idFriend' => '[0-9]+'])->name('fb.unfriend');
		Route::post('{uid}/ufl', 'FriendsController@unfriend_from_list')->name('fb.ufl'); // ufl <=> unfriend_from_list
	});

	Route::group(['prefix' => 'subto'], function() {
		Route::get('/{uid?}', 'SubToController@viewsubto')->name('fb.viewsubto')->where('uid', '[0-9]+');
	});

	Route::group(['prefix' => 'messenger'], function() {
		Route::get('{uid}/rank', 'MessengerController@rank')->name('fb.mess.messrank');
		Route::get('/rank', 'MessengerController@viewmess')->name('fb.mess.viewmess');
	});

	Route::group(['prefix' => 'status'], function () {
		Route::get('/{uid?}', 'WallController@getStatus')->name('fb.stt.getstt')->where('uid', '[0-9]+');
		Route::post('/{uid}/lmp', 'WallController@Ajax_LoadMorePost')->name('fb.stt.lmp')->where('uid', '[0-9]+'); // lmp <=> load more post
		Route::get('/delstt/{uid}/{idStatus}', 'WallController@deleteStatus')->name('fb.delstt');
		Route::get('/poststatus', 'WallController@postStatus')->name('fb.stt.poststt');
		Route::post('/poststatus', 'WallController@postStatus');
	});

	Route::group(['prefix' => 'auto'], function () {
		Route::get('/like', 'HackLikeController@ViewHackLike')->name('view.auto.like');
		Route::get('/sub', 'HackSubController@ViewHackSub')->name('view.auto.sub');
	});

	Route::group(['prefix' => 'nuoiclone'], function () {
		Route::get('/', 'NuoiCloneController@Viewnuoiclone')->name('fb.viewnuoiclone');
	});

	// Route::post('/clonefb', 'CloneController@createClone');
	Route::get('/regclone', 'CloneController@regClone');
});

Route::group(['prefix' => 'checkproxy'], function () {
	Route::get('/', 'CheckProxyController@viewcheckproxy')->name('fb.viewcheckproxy');
	Route::post('/', 'CheckProxyController@checkproxy')->name('fb.checkproxy');
});

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/updatefbaccount', 'HomeController@check_account');

Route::post('/fblogin', 'SocialController@login_facebook')->name('fb.login');

Route::get('/logout', 'Auth\LoginController@logout');

Auth::routes();

Route::get('/test', 'TestController@index');