<?php

namespace App\Http\Controllers\Facebook;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use TesseractOCR;

class HackLikeController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function ViewHackLike() {
		return view('auto.like');
	}

	public function test() {
		$test = new TesseractOCR(asset('public/images/1.jpg'));
		echo $test->a();
	}
}
