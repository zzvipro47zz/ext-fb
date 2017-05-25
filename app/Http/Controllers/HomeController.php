<?php

namespace App\Http\Controllers;

use DB;
use App\Social;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		$socials = Social::where('user_id', Auth::user()->id)->get()->toArray();
		$posts = json_decode(DB::table('posts')->join('socials', 'posts.social_id', '=', 'socials.id')->select('name', 'provider_uid', 'posts.*')->get(), true);
		
		return view('home', compact('socials', 'posts'));
	}
}
