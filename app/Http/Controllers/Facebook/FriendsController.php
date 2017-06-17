<?php

namespace App\Http\Controllers\Facebook;

use App\Http\Controllers\Controller;
use App\Social;
use Curl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendsController extends Controller {
	protected $user_agent;

	public function __construct() {
		$this->user_agent = agent();
	}

	public function viewgetfriends(Request $request, $uid = null) {
		$socials = Social::where('user_id', Auth::user()->id)->get()->toArray();

		if ($uid == null) {
			return view('auto.friends.getfriends', compact('socials'));
		}
		// get friend của $uid được truyền vào
		$user = Social::where('provider_uid', $uid)->get()->first();
		if (!$user) {
			return back()->with('error', 'Có lỗi xảy ra, uid facebook không đúng !');
		}
		$user = $user->toArray();

		$url_info_fr = mkurl(true, 'graph', 'facebook.com', "v2.9/$uid/friends", ['fields' => 'name,picture,cover{source}', 'access_token' => $user['access_token']]);
		$friends = json_decode(Curl::to($url_info_fr)->get(), true);
		if ($err_msg = CheckAndHandleFBErrCode($friends)) {
			return redirect('home')->with('error', $err_msg);
		}
		
		$friends_data = $friends['data'];
		$friends_page = $friends['paging']['next'];
		$request->session()->put('friends_page', $friends_page);
		$summary = $friends['summary']['total_count'];

		return view('auto.friends.getfriends', compact('user', 'socials', 'friends_data', 'summary'));
	}

	public function Ajax_LoadMoreFriends(Request $request, $uid) {
		if ($request->ajax()) {
			$user = Social::where('provider_uid', $uid)->get()->first()->toArray();
			if ($request->session()->has('friends_page')) {
				$friends_page = $request->session()->get('friends_page');
				$request->session()->forget('friends_page');
				$friends = json_decode(Curl::to($friends_page)->get(), true);
			}
			if (isset($friends['paging']['next']) && isset($friends_page)) {
				$request->session()->put('friends_page', $friends['paging']['next']);
			}
			if (!empty($friends['data'])) {
				return $friends['data'];
			}
			return 'okay';
		}
		return 'notokay';
	}

	public function unfriend(Request $request, $uid, $idFriend) {
		$user = Social::where('provider_uid', $uid)->get()->first()->toArray();
		if (!$user) {
			return back()->with('error', 'user facebook id không đúng!');
		}
		$cookie = $user['cookie'];

		$url_getdata_unfr = mkurl(true, 'mbasic', 'facebook.com', 'removefriend.php', ['friend_id' => $idFriend]);
		$get_data = Curl::to($url_getdata_unfr)
			->withOption('USERAGENT', $this->user_agent)
			->withHeader('cookie: '.$cookie)->get();
		preg_match('/fb_dtsg" value="(.+?)"/i', $get_data, $fb_dtsg);

		$post_fields = [
			'friend_id' => $idFriend,
			'fb_dtsg' => $fb_dtsg[1],
			'unref' => 'profile_gear',
			'confirm' => 'Confirmer',
		];
		$url_unfr = mkurl(true, 'mbasic', 'facebook.com', 'a/removefriend.php', null);
		Curl::to(mkurl(true, 'mbasic', 'facebook.com', 'a/removefriend.php'))
			->withOption('USERAGENT', $this->user_agent)
			->withData($post_fields)
			->withHeader('cookie: '.$cookie)->post();

		return back()->with('success', 'Hủy kết bạn thành công !');
	}

	public function unfriend_from_list(Request $request, $uid) {
		if ($request->ajax()) {
			$user = Social::where('provider_uid', $uid)->get()->first()->toArray();
			$cookie = $user['cookie'];
			$id = $request->id;

			$url_getdata_unfr = mkurl(true, 'mbasic', 'facebook.com', 'removefriend.php', ['friend_id' => $id]);
			$get_data = Curl::to($url_getdata_unfr)
				->withOption('USERAGENT', $this->user_agent)
				->withHeader('cookie: '.$cookie)->get();

			preg_match('/fb_dtsg" value="(.+?)"/i', $get_data, $fb_dtsg);
			if (empty($fb_dtsg)) {
				return 'notokay';
			}

			$post_fields = [
				'friend_id' => $id,
				'fb_dtsg' => $fb_dtsg[1],
				'unref' => 'profile_gear',
				'confirm' => 'Confirmer',
			];
			$url_unfr = mkurl(true, 'mbasic', 'facebook.com', 'a/removefriend.php', null);
			Curl::to($url_unfr)
				->withOption('USERAGENT', $this->user_agent)
				->withData($post_fields)
				->withHeader('cookie: '.$cookie)->post();

			return 'okay';
		}
		return 'notokay';
	}

	public function unfriend_all() {
		
	}
}
