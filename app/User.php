<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
	use Notifiable;
    
	protected $fillable = [
		'name', 'email', 'role',
	];

	protected $hidden = ['rememberToken'];
}
