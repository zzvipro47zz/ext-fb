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
	public function login_facebook(Request $request) {
		$username = $request->only('username')['username'];
		$password = $request->only('password')['password'];

		// nếu có tài khoản facebook trong hệ thống thì check
		$social = Social::where('email', $username)->orWhere('phone', $username)->first();
		if ($social) { // nếu đã có tk facebook thì kiểm tra pass
			if (Hash::check($password, $social->password)) {
				return back()->with('success', 'Tài khoản bạn vừa nhập đã có trong hệ thống !');
			}
			return back()->with('error', 'Sai tài khoản hoặc mật khẩu facebook !');
		} else { // không có tk fb trong hệ thống hoặc kiểm tra email và phone
			// request thông tin đến fb và return string thông tin người dùng
			$user_info = json_decode(sign_creator($username, $password), true);

			if (isset($user_info['error_code'])) {
				$error_msg = handlingfbcode($user_info);
				return back()->with('error', $error_msg);
			}
			$uid = $user_info['session_cookies'][0]['value'];
			$access_token = $user_info['access_token'];

			// graph lấy thông tin người dùng trên fb nếu đã đầy đủ thông tin
			$info_user_fb = json_decode(Curl::to(fb('graph', $uid, 'login'))->withData(['access_token' => $access_token])->get(), true);

			$name = $info_user_fb['name'];
			$gender = $info_user_fb['gender'] == 'male' ? 1 : 0;
			$mobile_phone = isset($info_user_fb['mobile_phone']) ? $info_user_fb['mobile_phone'] : null;
			$link = $info_user_fb['link'];

			// nếu đã có tài khoản trước đó thì thêm thông tin bị thiếu (email or phone)
			$social = Social::where('provider_uid', $uid)->first();
			if ($social) {
				return back()->with('success', 'Đăng nhập thành công !');
			} else {
				// chuyển đổi cookie. okay !
				$session_cookies = $user_info['session_cookies'];
				$len = count($session_cookies);
				$cookie = '';
				for ($i = 0; $i < $len; $i++) {
					$cookie .= $session_cookies[$i]['name'] . '=' . $session_cookies[$i]['value'] . ';';
				}

				$social = new Social;
				$social->provider_uid = $uid;
				$social->name = $name;
				$social->gender = $gender;
				$social->email = $username;
				$social->phone = $mobile_phone;
				$social->password = Hash::make($password);
				$social->link = $link;
				$social->access_token = $access_token;
				$social->cookie = $cookie;
				$social->provider = 'facebook';
				$social->user_id = Auth::user()->id;
				$social->save();

				return back()->with('success', 'Thêm tài khoản facebook vào hệ thống thành công !');
			}
		}
	}
}
