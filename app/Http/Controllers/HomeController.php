<?php

namespace App\Http\Controllers;

use App\Social;
use Illuminate\Support\Facades\Auth;
use Curl;

class HomeController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		$socials = Social::where('user_id', Auth::user()->id)->get()->toArray();
		return view('home', compact('socials'));
	}

	public function check_account() {
		$socials = Social::where('user_id', Auth::user()->id)->select('id', 'provider_uid', 'access_token', 'active')->get()->toArray();
		if ($socials) {
			foreach ($socials as $social) {
				if ($social['active'] === 1) {
					$url_user_info = mkurl(true, 'graph', 'facebook.com', "v1.0/$social[provider_uid]", ['access_token' => $social['access_token']]);
					$user_info = json_decode(Curl::to($url_user_info)->get(), true);
					
					$social = Social::find($social['id']);

					if ($err_msg = CheckAndHandleFBErrCode($user_info)) {
						$social->active = 0;
						$social->status = $err_msg;
						$social->access_token = null;
						$social->password = null;
						$social->cookie = null;
						$social->save();
					}
					
					$url_ttfr = mkurl(true, 'graph', 'facebook.com', "v2.9/$social->provider_uid/friends/", ['access_token' => $social->access_token]);
					$url_ttsub = mkurl(true, 'graph', 'facebook.com', "v1.0/$social->provider_uid/subscribers/", ['access_token' => $social->access_token]);
					$ttfr = json_decode(Curl::to($url_ttfr)->get(), true)['summary']['total_count'];
					$ttsub = json_decode(Curl::to($url_ttsub)->get(), true)['summary']['total_count'];
					if ($ttfr === $social->friends && $ttsub === $social->subs) {
						continue;
					}
					$social->friends = $ttfr;
					$social->subs = $ttsub;
					$social->email = $user_info['email'];
					$social->gender = $user_info['gender'] == 'male' ? 1 : 0;
					$social->name = $user_info['name'];
					$social->phone = isset($user_info['mobile_phone']) ? $user_info['mobile_phone'] : null;
					$social->link = $user_info['link'];
					$social->save();
				}
			}
			return back()->with('success', 'Cập nhật thành công !');
		}
		return back()->with('error', 'Bạn hãy đăng nhập trước khi kiểm tra tài khoản !!!');
	}
}
