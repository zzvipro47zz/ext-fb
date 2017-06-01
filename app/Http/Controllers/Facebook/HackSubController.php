<?php

namespace App\Http\Controllers\Facebook;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HackSubController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}
	
	public function ViewHackSub() {
		return view('auto.sub');
	}
}
