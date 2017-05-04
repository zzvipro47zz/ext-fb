<?php

namespace App\Http\Controllers;

class ViewController extends Controller {
	public function index() {
		return view('home');
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
