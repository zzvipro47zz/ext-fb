<?php

namespace App\Http\Controllers;

use TesseractOCR;

class TestController extends Controller {
	public function index() {
		$username = '+84903117850';
		echo preg_replace('/^0/i', '+84', $username);
	}
}
