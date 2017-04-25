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
		return view('dashboard');
	}

	public function friend() {
		return view('auto.others.unfriend');
	}

	public function wall() {
		return view('auto.wall');
	}

	public function group() {
		return view('auto.group');
	}
}
