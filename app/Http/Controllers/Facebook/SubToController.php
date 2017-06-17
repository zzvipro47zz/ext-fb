<?php

namespace App\Http\Controllers\Facebook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Social;
use Illuminate\Support\Facades\Auth;

class SubToController extends Controller {
	public function viewsubto(Request $request, $uid = null) {
		$socials = Social::where('user_id', Auth::user()->id)->get()->toArray();
		if (!$socials) {
			return redirect('home');
		}

		if (empty($uid)) {
			return view('auto.friends.subto', compact('socials'));
		}

		// xử lý code tồn tại $uid

	}
}
