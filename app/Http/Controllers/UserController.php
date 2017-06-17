<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\CreateUser;

class UserController extends Controller {
	public function __construct() {
		$this->middleware('admin');
	}

	public function create(CreateUser $request) {
		
	}

	public function edit($id) {

	}

	public function delete($id) {
		$user = User::find($id);
		$user->delete();
		return redirect()->route('admin.user');
	}
}
