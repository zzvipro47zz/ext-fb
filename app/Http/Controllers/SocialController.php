<?php

namespace App\Http\Controllers;

use App\Social;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Session;
use Socialite;

class SocialController extends Controller {
	/**
	 * Redirect the user to the Facebook authentication page.
	 *
	 * @return Response
	 */
	public function redirectToProvider() {
		return Socialite::driver('facebook')->scopes([
			'email',
			'public_profile',
			'user_likes',
			'user_videos',
			'user_photos',
			'user_posts',
			'user_status',
			'publish_actions',
		])->redirect();
	}

	/**
	 * Obtain the user information from Facebook.
	 *
	 * @return Response
	 */
	public function handleProviderCallback(Request $request) {
		$user = Socialite::driver('facebook')->user();
		
		Session::put('fb-sdk', $user);

		$social = Social::where('provider_user_id', $user->id)->where('provider', 'facebook')->first();
		if ($social) {
			$social->accesstoken = $user->token;
			$social->save();

			$u = User::where('email', $user->email)->first();
			Auth::login($u);

			return redirect()->back();
		} else {
			$temp = new Social;
			$temp->provider_user_id = $user->id;
			$temp->accesstoken = $user->token;
			$temp->provider = 'facebook';

			$u = User::where('email', $user->email)->first();
			if (!$u) {
				$u = User::create([
					'name' => $user->name,
					'email' => $user->email,
				]);
			}
			$temp->user_id = $u->id;
			$temp->save();

			Auth::login($u);

			return redirect()->back();
		}
	}
}
