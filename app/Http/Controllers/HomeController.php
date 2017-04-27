<?php

namespace App\Http\Controllers;

use Auth, Session;

class HomeController extends Controller {
	public function index() {
		return view('dashboard');
	}

	public function unfriend() {
		return view('auto.friend.unfriend');
	}

	public function addfriend() {
		return view('auto.friend.addfriend');
	}

	public function postWall() {
		return view('auto.wall.postWall');
	}

	public function group() {
		return view('auto.group');
	}
}
