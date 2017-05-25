<?php

namespace App\Http\Controllers\Facebook;

use App\Http\Controllers\Controller;
use App\Social;
use Curl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller {
	protected $user_agent = 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.96 Mobile Safari/537.36';

	public function __construct() {
		$this->middleware('auth');
	}

	public function getFriends(Request $request, $uid = null) {
		$socials = Social::where('user_id', Auth::user()->id)->get()->toArray();
		if (!$socials) {
			return redirect('home');
		}
		if ($uid == null) {
			return view('auto.friends', compact('socials'));
		}
		// $user dùng để lấy user đã được chọn để get friend
		$user = Social::where('provider_uid', $uid)->get()->first()->toArray();
		if (!$user) {
			return back()->with('error', 'Có lỗi xảy ra, uid facebook không đúng !');
		}

		$friends = json_decode(Curl::to(fb('graph', $uid . '/friends'))->withData(['fields' => 'name,picture,cover{source}', 'access_token' => $user['access_token']])->get(), true);
		$friends_data = $friends['data'];
		$friends_page = $friends['paging']['next'];
		$request->session()->put('friends_page', $friends_page);
		$summary = $friends['summary']['total_count'];

		return view('auto.friends', compact('user', 'socials', 'friends_data', 'summary'));
	}

	public function Ajax_LoadMoreFriends(Request $request, $uid) {
		if ($request->ajax()) {
			$user = Social::where('provider_uid', $uid)->get()->first()->toArray();
			$friends_page = $request->session()->get('friends_page');
			$friends = json_decode(Curl::to($friends_page)->get(), true);
			$friends_data = $friends['data'];
			$friends_page = $friends['paging']['next'];
			$request->session()->put('friends_page', $friends_page);

			return $friends_data;
		}
		return redirect('home')->with('error', 'Yêu cầu không đúng !');
	}

	public function unfriend(Request $request, $uid, $idFriend) {
		$user = Social::where('provider_uid', $uid)->get()->first()->toArray();
		if (!$user) {
			return back()->with('error', 'user facebook id không đúng!');
		}
		$cookie = $user['cookie'];

		$get_data = Curl::to(fb('mbasic', 'removefriend.php?friend_id=' . $idFriend))
			->withOption('USERAGENT', $this->user_agent)
			->withHeader('cookie: '.$cookie)->get();
		preg_match('/fb_dtsg" value="(.+?)"/i', $get_data, $fb_dtsg);

		$post_fields = [
			'friend_id' => $idFriend,
			'fb_dtsg' => $fb_dtsg[1],
			'unref' => 'profile_gear',
			'confirm' => 'Confirmer',
		];
		Curl::to(fb('mbasic', 'a/removefriend.php'))
			->withOption('USERAGENT', $this->user_agent)
			->withData($post_fields)
			->withHeader('cookie: '.$cookie)->post();

		return back()->with('success', 'Hủy kết bạn thành công !');
	}

	public function unfriend_from_list(Request $request, $uid) {
		$user = Social::where('provider_uid', $uid)->get()->first()->toArray();
		$cookie = $user['cookie'];
		$list_friend = $request->list_friend;

		foreach ($list_friend as $value) {
			$get_data = Curl::to(fb('mbasic', 'removefriend.php?friend_id=' . $value))
				->withOption('USERAGENT', $this->user_agent)
				->withHeader('cookie: '.$cookie)->get();

			preg_match('/fb_dtsg" value="(.+?)"/i', $get_data, $fb_dtsg);

			$post_fields = [
				'friend_id' => $value,
				'fb_dtsg' => $fb_dtsg[1],
				'unref' => 'profile_gear',
				'confirm' => 'Confirmer',
			];
			Curl::to(fb('mbasic', 'a/removefriend.php'))
				->withOption('USERAGENT', $this->user_agent)
				->withData($post_fields)
				->withHeader('cookie: '.$cookie)->post();
		}

		return back()->with('success', 'Hủy kết bạn theo danh sách mà bạn đã chọn, thành công !');
	}
}
