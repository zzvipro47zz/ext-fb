<?php

namespace App\Http\Controllers\Facebook;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatusRequest;
use App\Social;
use Curl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class WallController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function get_attachments($data, $user) {
		$detail_feed = [];
		$len = count($data);
		for ($i = 0; $i < $len; $i++) {
			$detail_feed[$i] = json_decode(Curl::to(fb('graph', $data[$i]->id . '/attachments'))->withData(['access_token' => $user['access_token']])->get());
			if (empty($detail_feed[$i]->data)) {
				unset($detail_feed[$i]);
				continue;
			}
			// lấy attachments object gán vào cho $feed
			$data[$i]->attachments = $detail_feed[$i]->data[0];

			// gán khi đã có attachments
			$attachments = $data[$i]->attachments;
			if (!isset($attachments->description) && isset($attachments->target->id)) {
				$description = json_decode(Curl::to(fb('graph', $attachments->target->id))->withData(['access_token' => $user['access_token']])->get());
				if (isset($description->description)) {
					$data[$i]->attachments->description = $description->description;
				}
			}
		}
		return $data;
	}

	public function getStatus(Request $request, $uid = null) {
		$users = Social::where('user_id', Auth::user()->id)->get();

		if (!$users) {
			return view('home')->with('error', 'Bạn chưa đăng nhập tài khoản facebook vào trong hệ thống !');
		}

		$users = $users->toArray();

		if (isset($uid)) {
			$user = Social::where('provider_uid', $uid)->get()->first();

			if (!$user) {
				return back()->with('error', 'Có lỗi xảy ra, uid facebook không đúng !');
			}

			$user = $user->toArray();
			// lấy bài viết trên tường nhà
			$feed = json_decode(Curl::to(fb('graph', $uid . '/feed'))->withData(['access_token' => $user['access_token']])->get());
			$data = $feed->data;
			$paging_next = $feed->paging->next;

			$request->session()->put('paging', $paging_next);

			$data = $this->get_attachments($data, $user);

			return view('auto.status.getstatus', compact('user', 'users', 'data', 'paging_next'));
		}
		return view('auto.status.getstatus', compact('users'));
	}

	public function Ajax_LoadMorePost(Request $request, $uid) {
		if ($request->ajax()) {
			$user = Social::where('provider_uid', $uid)->get()->first();
			$paging = $request->session()->get('paging');

			$feed = json_decode(Curl::to($paging)->get());
			$data = $feed->data;
			if (empty($data)) {
				return 'okay';
			}
			$paging_next = $feed->paging->next;

			$request->session()->put('paging', $paging_next);

			$data = $this->get_attachments($data, $user);
			return $data;
		}
		return back()->with('error', 'Yêu cầu không đúng !');
	}

	public function postStatus(StatusRequest $request, $uid = null) {
		$users = Social::where('user_id', Auth::user()->id)->get();
		if (!$users) {
			return view('home')->with('error', 'Bạn chưa đăng nhập tài khoản facebook vào trong hệ thống !');
		}

		$users = $users->toArray();

		if ($uid != null) {
			$user = Social::where('provider_uid', $uid)->get()->first();

			if (empty($request->behind) && empty($request->image)) {
				return back()->with('Fail', 'Gửi không thành công ! bạn phải điền đầy đủ');
			} elseif (!empty($request->behind) && empty($request->image)) {
				$feed = Curl::to(fb('graph', $user['provider_uid'] . '/feed'))
					->withData([
						'message' => $request->behind,
						'access_token' => $user['token'],
					])->post();
				preg_match("/:\"(.*)\"}/i", $feed, $post); // regex lấy id bài viết
				return back()->with('Success', '<a href="https://fb.com/' . $post[1] . '" target="_blank">Ấn vào đây</a> để xem bài viết của bạn');
			}
			return view('auto.status.poststatus', compact('user', 'users'));
		}
		return view('auto.status.poststatus', compact('users'));
	}
}
