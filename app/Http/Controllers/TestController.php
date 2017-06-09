<?php

namespace App\Http\Controllers;

use TesseractOCR;

class TestController extends Controller {
	public function index() {
		$urlHinh = getcwd() . '\images\1.jpg';
		$stdout = getcwd() . '\images\stdout';
		echo exec("tesseract $urlHinh $stdout");
		// echo trim(file_get_contents('stdout.txt'));
	}
}
