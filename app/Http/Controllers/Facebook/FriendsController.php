<?php

namespace App\Http\Controllers\Facebook;

use App\Http\Controllers\Controller;
use App\Social;
use Curl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Function friends with params $uid, $idUnfriend
	 * 1. $uid to get user_id need to get friends list
	 * 2. $idUnfriend to get id of the user_id friend to unfriend
	 */
	public function friends(Request $request, $uid = null, $idUnfriend = null) {
		$user_agent = 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.96 Mobile Safari/537.36';
		$socials = Social::where('user_id', Auth::user()->id)->get()->toArray();

		if ($uid != null) {
			// $user dùng để lấy user đã được chọn để get friend
			$user = Social::where('provider_uid', $uid)->get()->first()->toArray();

			if ($idUnfriend != null) {
				// cả 2 $ đều có thì unfriend $idUnfriend
				$cookie = $user['cookie'];

				$get_data = Curl::to(fb('mbasic', 'removefriend.php?friend_id=' . $idUnfriend))
					->withOption($user_agent)
					->withHeader('cookie: '.$cookie)->get();
				preg_match('/fb_dtsg" value="(.+?)"/i', $get_data, $fb_dtsg);

				$post_fields = [
					'friend_id' => $id,
					'fb_dtsg' => $fb_dtsg[1],
					'unref' => 'profile_gear',
					'confirm' => 'Confirmer',
				];
				Curl::to(fb('mbasic', 'a/removefriend.php'))->withOption('USERAGENT', $user_agent)
					->withData($post_fields)
					->withHeader('cookie: '.$cookie)->post();

				return back()->with('success', 'Hủy kết bạn thành công !');
			}

			$str_friends = Curl::to(fb('graph', $uid . '/friends'))->withData(['access_token' => $user['access_token']])->get();
			$friends = json_decode($str_friends)->data;

			foreach ($friends as $key => $friend) {
				$picture = Curl::to(fb('graph', $friend->id . '/picture'))->withData(['access_token' => $user['access_token'], 'redirect' => 'false'])->get();
				$picture = substr($picture, 1, strlen($picture)-2);
				$friends[$key]->picture = $picture;
			}

			return view('auto.friends', compact('user', 'socials', 'friends'));
		}
		return view('auto.friends', compact('socials'));
	}

	public function unfriend_from_list(Request $request, $uid) {
		$user = Social::where('provider_uid', $uid)->get()->first()->toArray();
		$cookie = $user['cookie'];
		$list_friend = $request->list_friend;
		$user_agent = 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.96 Mobile Safari/537.36';

		foreach ($list_friend as $value) {
			$get_data = Curl::to(fb('mbasic', 'removefriend.php?friend_id=' . $value))
				->withOption('USERAGENT', $user_agent)
				->withHeader('cookie: '.$cookie)->get();

			preg_match('/fb_dtsg" value="(.+?)"/i', $get_data, $fb_dtsg);

			$post_fields = [
				'friend_id' => $value,
				'fb_dtsg' => $fb_dtsg[1],
				'unref' => 'profile_gear',
				'confirm' => 'Confirmer',
			];
			Curl::to(fb('mbasic', 'a/removefriend.php'))->withOption('USERAGENT', $user_agent)
				->withData($post_fields)
				->withHeader('cookie: '.$cookie)->post();
		}

		return back()->with('success', 'Hủy kết bạn theo danh sách mà bạn đã chọn, thành công !');
	}
}
