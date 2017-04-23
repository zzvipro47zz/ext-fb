<?php

namespace App\Http\Controllers;

use Auth, Session;

class HomeController extends Controller {
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('home');
	}

	public function unfriend() {
		
	}
}
