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
		// check username và password đúng thì đăng nhập
		$credentials = [
			(preg_match('/@/i', $request->username) ? 'email' : 'phone') => $request->username,
			'password' => $request->password,
		];
		if (Auth::attempt($credentials)) {
			$social = User::find(Auth::user()->id)->to_social;
			$user = Curl::to(fb('graph', $social->provider_user_id))->withData(['access_token' => $social->access_token])->get();
			$user = json_decode($user);
			$user->access_token = $social->access_token;
			$request->session()->put('info_user_fb', $user);

			return view('dashboard', ['success' => 'Đăng nhập thành công !']);
		} else { // không đúng user
			// request thông tin đến fb và return string thông tin người dùng
			$str_user_info = sign_creator($request->username, $request->password);

			if (!preg_match('/error_code/i', $str_user_info)) {
				$user_info = json_decode($str_user_info);
				$access_token = $user_info->access_token;

				// graph lấy thông tin người dùng trên fb
				$info_user_fb = Curl::to(fb('graph', $user_info->session_cookies[0]->value))->withData(['access_token' => $access_token])->get();
				$info_user_fb = json_decode($info_user_fb);

				// thêm access_token vào object $user và lưu session
				$info_user_fb->access_token = $access_token;
				// save session
				Session::put('info_user_fb', $info_user_fb);

				// nếu đã có tài khoản trước đó thì thêm thông tin bị thiếu (email or phone)
				$social_user_id = Social::where('provider_user_id', $info_user_fb->id)->select('user_id')->first();
				if ($social_user_id) {
					$user = User::find($social_user_id)->update([
						(preg_match('/@/i', $request->username) ? 'email' : 'phone') => $request->username,
					]);
					$user = User::find($social_user_id);
					Auth::login($user);
					return back()->with('success', 'Đăng nhập thành công !');
				} else {
					// tạo user và đăng nhập user. okay !
					$user = new User;
					if (!preg_match('/@/i', $request->username)) {
						$user->phone = $request->username;
					} else {
						$user->email = $request->username;
					}
					$user->password = Hash::make($request->password);
					$user->save();
					// đăng nhập user
					Auth::login($user);

					// gán thông tin đã có
					$name = $info_user_fb->name;
					$uid = $info_user_fb->id;

					// chuyển đổi cookie. okay !
					$session_cookies = $user_info->session_cookies;
					$len = count($session_cookies);
					$cookie = '';
					for ($i = 0; $i < $len; $i++) {
						$cookie .= $session_cookies[$i]->name . '=' . $session_cookies[$i]->value . ';';
					}

					$temp = new Social;
					$temp->name = $name;
					$temp->provider_user_id = $uid;
					$temp->access_token = $access_token;
					$temp->cookie = $cookie;
					$temp->provider = 'facebook';
					$temp->user_id = $user->id;
					$temp->save();

					return back()->with('success', 'Đăng nhập thành công !');
				}
			} else {
				return back()->with('error', 'Wrong username or password !');
			}
		}
	}
}
