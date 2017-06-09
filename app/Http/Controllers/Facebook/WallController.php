<?php

namespace App\Http\Controllers\Facebook;

use App\Http\Controllers\Controller;
use App\Post;
use App\Social;
use Curl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class WallController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function getStatus(Request $request, $uid = null) {
		$socials = Social::where('user_id', Auth::user()->id)->get()->toArray();
		if (!$socials) {
			return view('home');
		}

		if ($uid == null) {
			return view('auto.status.getstatus', compact('socials'));
		}
		$user = Social::where('provider_uid', $uid)->get()->first()->toArray();
		if (!$user) {
			return back()->with('error', 'Có lỗi xảy ra, uid facebook không đúng !');
		}
		// lấy bài viết trên tường nhà
		$url_get_feed = mkurl(true, 'graph', 'facebook.com', "$uid/feed", ['fields' => 'message,description,story,name,link,type,full_picture,source,created_time', 'access_token' => $user['access_token']]);
		$feed = Curl::to($url_get_feed)->get();
		$feed_data = str_replace('\\n', '<br />', $feed);
		$feed = json_decode($feed_data, true);

		$stt_data = $feed['data'];
		$stt_page = $feed['paging']['next'];
		$request->session()->put('stt_page', $stt_page);

		return view('auto.status.getstatus', compact('user', 'socials', 'stt_data'));
	}

	public function Ajax_LoadMorePost(Request $request, $uid) {
		if ($request->ajax()) {
			$user = Social::where('provider_uid', $uid)->get()->first();
			if (!$user) {
				return back()->with('error', 'User Facebook ID không đúng !');
			}
			$stt_page = $request->session()->get('stt_page');

			$feed = Curl::to($stt_page)->get();
			$feed_data = str_replace('\\n', '<br />', $feed);
			$feed = json_decode($feed_data, true);

			$stt_data = $feed['data'];
			if (empty($stt_data)) {
				return 'okay';
			}
			$stt_page = $feed['paging']['next'];

			$request->session()->put('stt_page', $stt_page);
			return $stt_data;
		}
		return redirect('home')->with('error', 'Yêu cầu không đúng !');
	}

	public function postStatus(Request $request) {
		$socials = Social::where('user_id', Auth::user()->id)->get()->toArray();
		if (!$socials) {
			return view('home');
		}
		if ($request->uid == null) {
			return view('auto.status.poststatus', compact('socials'));
		}
		$social = Social::where('provider_uid', $request->uid)->get()->first()->toArray();
		if (!$social) {
			return back()->with('error', 'ID facebook không tồn tại trong hệ thống !');
		}

		$feed = '';
		if (empty($request->message) && empty($request->images)) {
			return back()->with('error', 'Đăng bài không thành công, bạn phải điền đầy đủ');
		} elseif (!empty($request->message && !$request->hasFile('images'))) {
			$feed = json_decode(Curl::to(fb('graph', $social['provider_uid'] . '/feed'))
					->withData([
						'message' => $request->message,
						'access_token' => $social['access_token'],
					])->post(), true);
			$this->insertPostStt(time(), $social['id'], $request->message);
		} elseif ($request->hasFile('images')) {
			$attached = $this->postUnpublishedPhotos($request->file('images'), $request->caption, $social);
			$message = [
				'message' => $request->message,
				'access_token' => $social['access_token'],
			];
			$data = array_merge($attached, $message);
			$feed = json_decode(Curl::to(fb('graph', $social['provider_uid'] . '/feed'))->withData($data)->post(), true);
		}
		if (!empty($feed['error'])) {
			$error = handlingfbcode($feed['error']);
			return back()->with('error', 'Lỗi ' . $error . ', vui lòng liên hệ QTV để fix (:');
		}
		return back()->with('success', 'Đăng bài thành công. <a href="https://fb.com/' . $feed['id'] . '" target="_blank">Ấn vào đây</a> để xem bài viết của bạn');
	}

	public function postUnpublishedPhotos($files, $captions, $social) {
		$photos = [];
		$attached_media = [];
		$media_fbid = [];
		// upload image lên server và đăng bài viết với chế độ published=false
		foreach ($files as $key => $value) {
			if ($file[$key]->isValid()) {
				$url_picture = upanh($file[$key]->getPathname()); // tmp name

				$photos[$key] = json_decode(Curl::to(fb('graph', $social['provider_uid'] . '/photos'))->withData([
					'mkurl' => $url_picture,
					'caption' => $captions[$key],
					'published' => 'false',
					'access_token' => $social['access_token'],
				])->post())->id;

				$attached_media[$key] = 'attached_media[' . $key . ']';
				$media_fbid[$key] = '{"media_fbid":"' . $photos[$key] . '"}';
			}
		}
		$attached = array_combine($attached_media, $media_fbid);
		return $attached;
	}

	public function deleteStatus($uid, $idStatus) {
		$user = Social::where('provider_uid', $uid)->get()->first()->toArray();
		if (!$user) {
			return back()->with('error', 'User không tồn tại trong hệ thống');
		}
		$url_del_stt = mkurl(true, 'graph', 'facebook.com', $idStatus, ['access_token' => $user['access_token']]);
		$delstt = json_decode(Curl::to($url_del_stt)->delete(), true);
		if ($delstt['success']) {
			return back()->with('success', 'Xóa bài viết thành công !');
		}
		return back()->with('error', 'Có lỗi xảy ra khi xóa bài viết !');
	}
}
