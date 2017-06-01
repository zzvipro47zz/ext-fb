<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CloneFb extends Model {
	protected $fillable = [
		'name',
		'email',
		'phone',
		'password',
		'gender',
		'active',
		'access_token',
	];
}
