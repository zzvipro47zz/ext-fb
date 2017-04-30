<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model {
	protected $fillable = [
		'provider_user_id', 'access_token', 'likes', 'posts', 'provider', 'user_id',
	];
}
