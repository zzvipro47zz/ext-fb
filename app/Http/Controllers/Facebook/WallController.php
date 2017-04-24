<?php

namespace App\Http\Controllers\Facebook;

use Curl;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class WallController extends Controller {
	public function getWall() {
		return view('auto.wall.getStatuses');
	}

	public function getStatuses() {
		$feed = Curl::to(fb('graph', 'me/feed'));
		
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
