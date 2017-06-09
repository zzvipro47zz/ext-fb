<?php

namespace App\Http\Controllers;

use App\Social;
use App\User;
use Curl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SocialController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function login_facebook(Request $request) {
		$username = $request->only('username')['username'];
		$password = $request->only('password')['password'];

		// nếu có tài khoản facebook trong hệ thống thì check
		$social = Social::where('email', $username)->orWhere('phone', $username)->first();
		if ($social) { // nếu đã có tk facebook thì kiểm tra pass
			if (Hash::check($password, $social->password)) {
				$ttfr = json_decode(Curl::to(mkurl(true, 'graph', 'facebook.com', "v2.9/$social->provider_uid/friends/", ['access_token' => $social->access_token])['summary']['total_count'])->get(), true);
				$ttsub = json_decode(Curl::to(mkurl(true, 'graph', 'facebook.com', "v1.0/$social->provider_uid/subscribers/", ['access_token' => $social->access_token])['summary']['total_count'])->get(), true);
				if ($social->friends != $ttfr && $social->subs != $ttsub) {
					$social->friends = $ttfr;
					$social->subs = $ttsub;
				} else {
					if ($social->friends != $ttfr) {
						$social->friends = $ttfr;
					} else {
						$social->subs = $ttsub;
					}
				}
				$social->save();

				return back()->with('success', 'Tài khoản bạn vừa nhập đã có trong hệ thống !');
			}
			return back()->with('error', 'Sai tài khoản hoặc mật khẩu facebook !');
		} else {
			$user_info = json_decode(sign_creator($username, $password), true);
			if (isset($user_info['error_code'])) {
				$error_msg = handlingfbcode($user_info);
				return redirect('home')->with('error', $error_msg);
			}
			$uid = $user_info['session_cookies'][0]['value'];
			// nếu đã có tk trong hệ thống
			if (isset($social->provider_uid) && $social->provider_uid == $uid) {
				if (preg_match('/@/i', $username) && empty($social->email)) {
					$social->email = $username;
				} else {
					$social->phone = $username;
				}
				$social->save();
				return back()->with('success', 'Đăng nhập thành công !');
			}
			$access_token = $user_info['access_token'];

			// graph lấy thông tin người dùng trên fb nếu đã đầy đủ thông tin
			$info_user_fb = json_decode(Curl::to(mkurl(true, 'graph', 'facebook.com', "v1.0/$uid", ['access_token' => $access_token]))->get(), true);

			$name = $info_user_fb['name'];
			$gender = $info_user_fb['gender'] == 'male' ? 1 : 0;
			$mobile_phone = isset($info_user_fb['mobile_phone']) ? $info_user_fb['mobile_phone'] : null;
			$link = $info_user_fb['link'];
			$email = isset($info_user_fb['email']) ? $info_user_fb['email'] : null;
			$cookie = convert_cookie($user_info['session_cookies']);

			$ttfr = json_decode(Curl::to(mkurl(true, 'graph', 'facebook.com', "v2.9/$social->provider_uid/friends/", ['access_token' => $social->access_token])['summary']['total_count'])->get(), true);
			$ttsub = json_decode(Curl::to(mkurl(true, 'graph', 'facebook.com', "v1.0/$social->provider_uid/subscribers/", ['access_token' => $social->access_token])['summary']['total_count'])->get(), true);

			$social = new Social;
			$social->provider_uid = $uid;
			$social->name = $name;
			$social->gender = $gender;
			$social->email = $email;
			$social->phone = $mobile_phone;
			$social->password = Hash::make($password);
			$social->link = $link;
			$social->friends = $ttfr;
			$social->subs = $ttsub;
			$social->access_token = $access_token;
			$social->cookie = $cookie;
			$social->provider = 'facebook';
			$social->user_id = Auth::user()->id;
			$social->save();

			return redirect('home')->with('success', 'Thêm tài khoản facebook vào hệ thống thành công !');
		}
	}
}
