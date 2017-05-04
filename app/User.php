<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
	use Notifiable;
    
	protected $fillable = [
		'email', 'phone', 'password', 'role',
	];

	protected $hidden = ['rememberToken'];

	public function to_social() {
		return $this->hasMany('App\Social');
	}
}
