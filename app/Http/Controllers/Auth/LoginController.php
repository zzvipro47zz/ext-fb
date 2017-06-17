<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Social;
use Auth;
use Curl;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller {
	use AuthenticatesUsers;

	protected $redirectTo = '/home';

	public function __construct() {
		$this->middleware('guest', ['except' => 'logout']);
	}

	public function authenticated() {
		if (Auth::user()['role'] == 1) {
			$this->redirectTo = '/admin';
		}
	}
}
