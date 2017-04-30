<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Social;
use User;

class SocialController extends Controller {
	public function login_facebook(Request $request) {
		$user_info = sign_creator($request->username, $request->password);

		preg_match('/uid\":(\d+),/i', $user_info, $uid);
		preg_match('/access_token\":\"(\w+)\",/i', $user_info, $access_token);
		preg_match('/session_cookies\":\[(.*)\],/i', $user_info, $session_cookies);


		$session_cookies = $user_info->session_cookies;
		$len = count($session_cookies);
		$cookie = '';
		for ($i=0; $i < $len; $i++) { 
			$cookie .= $session_cookies['name'] . '=' . $session_cookies['value'] . '; ';
		}



		if (!preg_match('/error_code/i', $user_info)) {
			$social = Social::where('provider_user_id', $uid[1])->where('provider', 'facebook')->first();
			if ($social) {
				$social->access_token = $access_token[1];
				$social->save();

				$u = User::where('username', $request->username)->first();
				Auth::login($u);

				return redirect()->route('index');
			} else {
				$temp = new Social;
				$temp->provider_user_id = $uid[1];
				$temp->access_token = $access_token[1];
				$temp->provider = 'facebook';

				$u = User::where('username', $request->username)->first();
				if (!$u) {
					$u = User::create([
						'name' => $user_info->name,
						'username' => $request->username,
					]);
				}
				$temp->user_id = $u->id;
				$temp->save();

				Auth::login($u);

				return redirect()->route('index');
			}
		} else {
			return back()->with('error', 'Wrong username or password');
		}
	}
}
