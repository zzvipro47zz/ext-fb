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
			if ($proxy_info['type'] === 'success') {
				$file = fopen($url_file, 'a');
				 // . '|' . $proxy_info['response_time']
				fwrite($file, $proxy . "\n");
				fclose($file);
				return 'okay';
			}
			return $proxy_info;
		}
	}
}
