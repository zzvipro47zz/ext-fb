<?php

namespace App\Http\Controllers\Facebook;

use App\CloneFb;
use App\Http\Controllers\Controller;
use Curl;
use Illuminate\Http\Request;

class CloneController extends Controller {
	public function regClone(Request $request) {
		$agent = 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36';
		$clonefb = clonefb();
        dd($clonefb);
	}

	public function createClone(Request $request) {
		$clone = new CloneFb;
		$clone->email = $request->email;
		$clone->password = $request->password;
		$clone->save();
	}
}
