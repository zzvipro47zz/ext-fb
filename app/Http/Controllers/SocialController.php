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
		// nếu có tài khoản facebook trong hệ thống thì thêm vào user
		$social = Social::where('email', $request->username)->orWhere('phone', $request->username)->first();
		if ($social) { // nếu đã có tk facebook thì kiểm tra pass
			if (Hash::check($request->password, $social->password)) {
				$user = Curl::to(fb('graph', $social->provider_user_id))->withData(['access_token' => $social->access_token])->get();
				$user = json_decode($user);
				$user->access_token = $social->access_token;
				$request->session()->put($social->provider_user_id, $user);

				return back()->with('success', 'Đăng nhập thành công !');
			}
			return back()->with('error', 'Bạn đã nhập sai pass facebook !');
		} else { // không có tk fb trong hệ thống hoặc kiểm tra email và phone
			// request thông tin đến fb và return string thông tin người dùng
			$str_user_info = sign_creator($request->username, $request->password);

			// nếu đúng tài khoản
			if (!preg_match('/error_code/i', $str_user_info)) {
				$user_info = json_decode($str_user_info);

				$name = $user_info->name;
				$uid = $user_info->session_cookies[0]->value;
				$access_token = $user_info->access_token;

				// nếu đã có tài khoản trước đó thì thêm thông tin bị thiếu (email or phone)
				$social_user_id = Social::where('provider_user_id', $uid)->select('id')->first();
				if ($social_user_id) {
					Social::find($social_user_id)->update([
						(preg_match('/@/i', $request->username) ? 'email' : 'phone') => $request->username,
					]);

					return back()->with('success', 'Đăng nhập thành công !');
				} else {
					// chuyển đổi cookie. okay !
					$session_cookies = $user_info->session_cookies;
					$len = count($session_cookies);
					$cookie = '';
					for ($i = 0; $i < $len; $i++) {
						$cookie .= $session_cookies[$i]->name . '=' . $session_cookies[$i]->value . ';';
					}

					$username = preg_match('/@/i', $request->username) ? 'email' : 'phone';

					$temp = new Social;
					$temp->name = $name;
					$temp->$username = $request->username;
					$temp->password = Hash::make($request->password);
					$temp->provider_user_id = $uid;
					$temp->access_token = $access_token;
					$temp->cookie = $cookie;
					$temp->provider = 'facebook';
					$temp->user_id = $user->id;
					$temp->save();

					return back()->with('success', 'Đăng nhập thành công !');
				}

				// graph lấy thông tin người dùng trên fb
				$info_user_fb = Curl::to(fb('graph', $uid))->withData(['access_token' => $access_token])->get();
				$info_user_fb = json_decode($info_user_fb);

				// thêm access_token vào object $user và lưu session
				$info_user_fb->access_token = $access_token;
				// save session
				Session::put($uid, $info_user_fb);
			} else {
				return back()->with('error', 'Wrong username or password !');
			}
		}
	}
}
