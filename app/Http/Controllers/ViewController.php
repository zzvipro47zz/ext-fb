<?php

namespace App\Http\Controllers;

use App\Social;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		$socials = Social::where('user_id', Auth::user()->id)->get()->toArray();

		return view('home', compact('socials'));
	}

	public function getFriends() {
		$users = Social::where('user_id', Auth::user()->id)->get()->toArray();

		return view('auto.friends', compact('users'));
	}

	public function ajax_getFriends($uid) {
		if ($request->ajax()) {
			$user = Social::where('provider_uid', $uid)->get()->toArray();

			$friends = Curl::to(fb('graph', $uid.'/friends'))->withData(['access_token' => $user['access_token']])->get();
			echo $friends;

			return 'okay';
		}
		return route('fb.friends');
	}

	public function getInfoUsers() {
		$users = Social::where('user_id', Auth::user()->id)->get()->toArray();

		return view('auto.friends', compact('users'));
	}

	public function postWall() {
		return view('auto.wall.postWall');
	}

	public function group() {
		return view('auto.group');
	}
}
