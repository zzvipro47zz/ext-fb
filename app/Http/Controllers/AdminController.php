<?php

namespace App\Http\Controllers;

use App\User;
use Auth;

class AdminController extends Controller {
	public function __construct() {
		$this->middleware('admin');
	}

	public function index() {
		$user = Auth::user();
		return view('admin.index', compact('user'));
	}

	public function user() {
		$users = User::all()->toArray();
		return view('admin.user', ['users' => $users]);
	}
}
