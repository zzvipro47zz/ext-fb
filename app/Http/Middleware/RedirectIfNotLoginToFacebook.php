<?php

namespace App\Http\Middleware;

use Closure;
use App\Social;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotLoginToFacebook {
	public function handle($request, Closure $next) {
		$socials = Social::where('user_id', Auth::user()->id)->get()->toArray();
        if ($socials) {
            return $next($request);
        }
        return redirect('/');
	}
}
