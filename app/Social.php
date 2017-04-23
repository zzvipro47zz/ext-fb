<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model {
	protected $fillable = [
		'provider_user_id', 'accesstoken', 'provider', 'user_id',
	];
}
