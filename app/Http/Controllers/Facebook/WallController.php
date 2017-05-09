<?php

namespace App\Http\Controllers\Facebook;

use App\Http\Controllers\Controller;
use Curl;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Social;

class WallController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getStatuses() {
		$feed = Curl::to(fb('graph', 'me/feed'));

	}

	public function getFriends(Request $request, $uid) {
		$users = Social::where('user_id', Auth::user()->id)->get()->toArray();

		// $user dùng để lấy user đã được chọn để get friend
		$user = Social::where('provider_uid', $uid)->get()->first()->toArray();

		$str_friends = Curl::to(fb('graph', $uid . '/friends'))->withData(['access_token' => $user['access_token']])->get();
		$friends = json_decode($str_friends)->data;

		return view('auto.friends')->with(['users' => $users, 'friends' => $friends]);
	}

	public function unfriend($uid, $id) {
		$user = Social::where('provider_uid', $uid)->get()->first()->toArray();

		$get_fb_dtsg = Curl::to(fb('mbasic', '/'))
			// ->withData(['friend_id='.$id, 'unref=profile_gear', 'refid=8'])
			->withHeaders(['cookie: '.$user['cookie']])
			->get();
		dd($get_fb_dtsg);

		$unfriend = Curl::to(fb('mbasic', 'a/removefriend.php'))
			->withData([
				'access_token' => $user['access_token'],
				'friend_id' => $id,
				'unref' => 'profile_gear',
				'fb_dtsg' => 'AQC4AoV0',
				'confirm' => 'Confirmer'
			])->get();

		dd($unfriend);
		return;
	}

	public function postWall(Request $request) {
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
