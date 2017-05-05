<?php

namespace App\Http\Controllers;

use App\Social;
use App\User;
use Curl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SocialController extends Controller {
	public function login_facebook(Request $request) {
		// nếu có tài khoản facebook trong hệ thống thì thêm vào user
		$social = Social::where('email', $request->username)->orWhere('phone', $request->username)->first();
		if ($social) { // nếu đã có tk facebook thì kiểm tra pass
			if (Hash::check($request->password, $social->password)) {
				$request->session()->put($social->provider_uid, $social);

				return back()->with('success', 'Đăng nhập thành công !');
			}
			return back()->with('error', 'Bạn đã nhập sai pass facebook !');
		} else { // không có tk fb trong hệ thống hoặc kiểm tra email và phone
			// request thông tin đến fb và return string thông tin người dùng
			$str_user_info = sign_creator($request->username, $request->password);

			// nếu đúng tài khoản
			if (!preg_match('/error_code/i', $str_user_info)) {
				$user_info = json_decode($str_user_info);

				$uid = $user_info->session_cookies[0]->value;
				$access_token = $user_info->access_token;

				// graph lấy thông tin người dùng trên fb nếu đã đầy đủ thông tin
				$info_user_fb = Curl::to(fb('graph', $uid))->withData(['access_token' => $access_token])->get();
				$info_user_fb = json_decode($info_user_fb);

				$name = $info_user_fb->name;

				// nếu đã có tài khoản trước đó thì thêm thông tin bị thiếu (email or phone)
				$social_user_id = Social::where('provider_uid', $uid)->first();
				if ($social_user_id) {
					$request()->session()->put($social->provider_uid, $social);

					return back()->with('success', 'Đăng nhập thành công !');
				} else {
					// chuyển đổi cookie. okay !
					$session_cookies = $user_info->session_cookies;
					$len = count($session_cookies);
					$cookie = '';
					for ($i = 0; $i < $len; $i++) {
						$cookie .= $session_cookies[$i]->name . '=' . $session_cookies[$i]->value . ';';
					}

					$social = new Social;
					$social->provider_uid = $uid;
					$social->name = $name;
					$social->gender = ($info_user_fb->gender == 'male' ? 1 : 0);
					$social->email = $request->username;
					$social->phone = ($info_user_fb->mobile_phone ? $info_user_fb->mobile_phone : null);
					$social->password = Hash::make($request->password);
					$social->link = $info_user_fb->link;
					$social->access_token = $access_token;
					$social->cookie = $cookie;
					$social->provider = 'facebook';
					$social->user_id = Auth::user()->id;
					$social->save();

					$request()->session()->put($uid, $social);

					return back()->with('success', 'Thêm tài khoản facebook vào hệ thống thành công !');
				}

				// save session
				$request()->session()->put($uid, $info_user_fb);
			} else {
				return back()->with('error', 'Wrong username or password !');
			}
		}
	}
}
