<?php

namespace App\Http\Controllers\Facebook;

use App\Http\Controllers\Controller;
use Curl;
use Illuminate\Http\Request;
use Session;

class WallController extends Controller {
	public function __construct() {
		// $this->middleware('auth');
	}

	public function getStatuses() {
		$feed = Curl::to(fb('graph', 'me/feed'));

	}

	public function getFriends($relative_url) {
		$info = Session::get('fb-sdk');

		$startindex = 0;
		$idFriend = Curl::to(fb('mbasic', 'profile.php?v=friends&id=' . $info->id . '&startindex=' . $startindex))
			->withData(['access_token' => $info->token])->get();

		$graph_friends = Curl::to(fb('graph', $info->id . '/friends'))->withData(['access_token' => $info->token])->get();
		preg_match("/total_count\":(\d+)/i", $graph_friends, $total_count);
		return view('auto.friend.' . $relative_url . 'friend', compact('total_count'));
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
