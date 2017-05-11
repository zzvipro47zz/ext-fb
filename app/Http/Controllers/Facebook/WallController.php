<?php

namespace App\Http\Controllers\Facebook;

use App\Http\Controllers\Controller;
use App\Social;
use Curl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class WallController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getFriends($uid) {
		$users = Social::where('user_id', Auth::user()->id)->get()->toArray();

		// $user dùng để lấy user đã được chọn để get friend
		$user = Social::where('provider_uid', $uid)->get()->first()->toArray();

		$str_friends = Curl::to(fb('graph', $uid . '/friends'))->withData(['access_token' => $user['access_token']])->get();
		$friends = json_decode($str_friends)->data;

		return view('auto.friends')->with(['users' => $users, 'friends' => $friends]);
	}

	public function unfriend($uid, $id) {
		$user = Social::where('provider_uid', $uid)->get()->first()->toArray();
		$cookie = $user['cookie'];

		$get_data = CurlToFBWithCookie(fb('mbasic', 'removefriend.php?friend_id=' . $id), $cookie);
		preg_match('/fb_dtsg" value="(.+?)"/i', $get_data, $fb_dtsg);
		$post_fields = [
			'friend_id' => $id,
			'fb_dtsg' => $fb_dtsg[1],
			'unref' => 'profile_gear',
			'confirm' => 'Confirmer',
		];
		$unfriend = CurlToFBWithCookie(fb('mbasic', 'a/removefriend.php'), $cookie, $post_fields);

		return back()->with('success', 'Hủy kết bạn thành công !');
	}

	public function getStatus($uid) {
		$user = Social::where('provider_uid', $uid)->get()->first()->toArray();
		$feed = Curl::to(fb('graph', 'me/feed'))->withData(['access_token' => $user['access_token']])->get();

		return view('auto.wall.getstatus', compact('feed'));
	}

	public function postStatus(Request $request) {
		$this->validate($request, [
			'image' => 'image|mimes:jpg,png,jpeg',
		]);

		$info = Session::get('fb-sdk');

		if (empty($request->behind) && empty($request->image)) {
			return back()->with('Fail', 'Gửi không thành công ! bạn phải điền đầy đủ');
		} elseif (!empty($request->behind) && empty($request->image)) {
			$feed = Curl::to(fb('graph', 'me/feed'))
				->withData([
					'message' => $request->behind,
					'access_token' => $info->token,
				])->post();
			preg_match("/:\"(.*)\"}/i", $feed, $post); // regex lấy id bài viết
			return back()->with('Success', '<a href="https://fb.com/' . $post[1] . '" target="_blank">Ấn vào đây</a> để xem bài viết của bạn');
		}
	}
}
