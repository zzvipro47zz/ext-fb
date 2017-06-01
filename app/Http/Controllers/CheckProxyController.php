<?php

namespace App\Http\Controllers;

use App\CloneFb;
use Curl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckProxyController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function viewcheckproxy() {
		return view('auto.checkproxy');
	}

	public function checkproxy(Request $request) {
		if ($request->ajax()) {
			$proxy = $request->proxy;
			$url_file = $request->url_file;

			$proxy_info = check_proxy($proxy);
			return $proxy_info;
			if ($proxy_info == null) {
				return;
			}
			$file = fopen($url_file, 'a');
			if (isset($proxy_info['success']) && $proxy_info['success'] === true) {
				fwrite($file, $proxy . '|' . $proxy_info['response_time'] . '|' . $proxy_info['speed'] . "\n");
			}
			fclose($file);
			return 'okay';
		}
	}
}
