<?php

namespace App\Http\Controllers;

use App\Social;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller {
	public function index() {
		$socials = Social::where('user_id', Auth::user()->id)->get()->toArray();

		return view('home', compact('socials'));
	}

	public function getInfoUsers() {
		$users = Social::where('user_id', Auth::user()->id)->get()->toArray();

		return view('auto.friends', compact('users'));
	}

	public function postWall() {
		return view('auto.wall.postWall');
	}

	public function group() {
		return view('auto.group');
	}
}
