<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model {
	protected $fillable = [
		'name',
		'provider_user_id',
		'access_token',
		'likes',
		'posts',
		'provider',
		'user_id',
	];

	public function to_user() {
		$this->belongsTo('App\User');
	}
}
