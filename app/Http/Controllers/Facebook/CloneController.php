<?php

namespace App\Http\Controllers\Facebook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CloneFb;

class CloneController extends Controller {
	public function createClone(Request $request) {
		$clone = new CloneFb;
		$clone->name = $request->name;
		$clone->email = $request->email;
		$clone->phone = $request->phone;
		$clone->password = $request->password;
		$clone->gender = $request->gender;
		$clone->active = $request->active;
		$clone->access_token = $request->access_token;
		$clone->save();
	}
}
