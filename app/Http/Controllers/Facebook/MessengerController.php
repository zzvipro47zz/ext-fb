<?php

namespace App\Http\Controllers\Facebook;

use App\Http\Controllers\Controller;
use App\Social;
use Illuminate\Support\Facades\Auth;
use Curl;

class MessengerController extends Controller {
	protected $data_message = [];

	public function __construct() {
		$this->middleware('auth');
	}

	public function viewmess() {
		$socials = Social::where('user_id', Auth::user()->id)->get()->toArray();
		return view('auto.mess.messrank', compact('socials'));
	}

	public function rank($uid) {
		$socials = Social::where('provider_uid', $uid)->get()->toArray();
		$social = Social::where('provider_uid', $uid)->first()->toArray();
		
		$this->messrank(null, null, $social);

		$messrank = arr_sort($this->data_message, 'message_count', SORT_DESC);
		array_splice($messrank, 15);
		
		return view('auto.mess.messrank', compact('socials', 'messrank'));
	}

	public function messrank($mess_data = null, $page = null, $social = null) {
		if (empty($mess_data) && empty($page)) {
			$page = mkurl(true, 'graph', 'facebook.com', "v2.9/$social[provider_uid]/conversations", ['fields' => 'message_count,link,unread_count,participants,senders,can_reply,is_subscribed', 'access_token' => $social['access_token']]);
		}
		$mess = json_decode(Curl::to($page)->get(), true);
		$mess_data = $mess['data'];

		$this->data_message = array_merge($this->data_message, $mess_data);
		if (isset($mess['paging']['next'])) {
			$page = $mess['paging']['next'];
		} else {
			return;
		}
		$this->messrank($mess_data, $page);
	}
}
