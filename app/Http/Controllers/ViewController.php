<?php

namespace App\Http\Controllers;

use App\Social;
use Curl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		$socials = Social::where('user_id', Auth::user()->id)->get()->toArray();

		return view('home', compact('socials'));
	}

	public function friends() {
		$users = Social::where('user_id', Auth::user()->id)->get()->toArray();

		return view('auto.friends', compact('users'));
	}

	public function getStatus() {
		$users = Social::where('user_id', Auth::user()->id)->get()->toArray();

		return view('auto.wall.getstatus', compact('users'));
	}

	public function postWall() {
		return view('auto.wall.postWall');
	}

	public function group() {
		return view('auto.group');
	}
}
