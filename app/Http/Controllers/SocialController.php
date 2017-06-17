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

		$social = Social::where('email', $username)->orWhere('phone', preg_replace('/^0/i', '+84', $username))->first();
		if ($social) {
			if (Hash::check($password, $social->password) && $social->active === 1) {
				return redirect('home')->with('success', 'Tài khoản bạn vừa nhập đã có sẵn trong hệ thống, Ấn cập nhật tài khoản facebook để cập nhật');
			} else {
				// đăng nhập
				$user_info = json_decode(sign_creator($username, $password), true);
				if ($err_msg = CheckAndHandleFBErrCode($user_info)) {
					return redirect('home')->with('error', $err_msg);
				}

				$uid = $user_info['session_cookies'][0]['value'];
				$access_token = $user_info['access_token'];
				$cookie = convert_cookie($user_info['session_cookies']);

				$info_user_fb = json_decode(Curl::to(mkurl(true, 'graph', 'facebook.com', "v1.0/$uid", ['access_token' => $access_token]))->get(), true);

				// nếu access_token hợp lệ, cập nhật thông tin người dùng
				$name = $info_user_fb['name'];
				$email = isset($info_user_fb['email']) ? $info_user_fb['email'] : null;
				$gender = $info_user_fb['gender'] == 'male' ? 1 : 0;
				$mobile_phone = isset($info_user_fb['mobile_phone']) ? $info_user_fb['mobile_phone'] : null;
				$link = $info_user_fb['link'];

				$social->active = 1;
				$social->name = $name;
				$social->password = Hash::make($password);
				$social->email = $email;
				$social->gender = $gender;
				$social->phone = $mobile_phone;
				$social->link = $link;
				$social->access_token = $access_token;
				$social->cookie = $cookie;
				return redirect('home')->with('success', 'Cập nhật tài khoản facebook thành công !');
			}
			return redirect('home')->with('error', 'Lỗi không xác định !');
		} else {
			// đăng nhập
			$user_info = json_decode(sign_creator($username, $password), true);
			if ($err_msg = CheckAndHandleFBErrCode($user_info)) {
				return redirect('home')->with('error', $err_msg);
			}

			$uid = $user_info['session_cookies'][0]['value'];
			$access_token = $user_info['access_token'];
			$cookie = convert_cookie($user_info['session_cookies']);

			// graph lấy thông tin người dùng trên fb nếu đã đầy đủ thông tin
			$url_ttfr = mkurl(true, 'graph', 'facebook.com', "v2.9/$social->provider_uid/friends/", ['access_token' => $access_token]);
			$url_ttsub = mkurl(true, 'graph', 'facebook.com', "v1.0/$social->provider_uid/subscribers/", ['access_token' => $access_token]);
			$url_info_user_fb = mkurl(true, 'graph', 'facebook.com', "v1.0/$uid", ['access_token' => $access_token]);

			$ttfr = json_decode(Curl::to($url_ttfr)->get(), true)['summary']['total_count'];
			$ttsub = json_decode(Curl::to($url_ttsub)->get(), true)['summary']['total_count'];
			$info_user_fb = json_decode(Curl::to($url_info_user_fb)->get(), true);

			$name = $info_user_fb['name'];
			$gender = $info_user_fb['gender'] == 'male' ? 1 : 0;
			$mobile_phone = isset($info_user_fb['mobile_phone']) ? $info_user_fb['mobile_phone'] : null;
			$link = $info_user_fb['link'];
			$email = isset($info_user_fb['email']) ? $info_user_fb['email'] : null;

			$social = new Social;
			$social->provider_uid = $uid;
			$social->name = $name;
			$social->email = $email;
			$social->gender = $gender;
			$social->phone = $mobile_phone;
			$social->password = Hash::make($password);
			$social->link = $link;
			$social->friends = $ttfr;
			$social->subs = $ttsub;
			$social->access_token = $access_token;
			$social->cookie = $cookie;
			$social->provider = 'facebook';
			$social->active = 1;
			$social->user_id = Auth::user()->id;
			$social->save();
			return redirect('home')->with('success', 'Đăng nhập thành công !');
		}
	}
}
