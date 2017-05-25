<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {
	protected $fillable = ['id', 'message', 'caption', 'image', 'type', 'post_at', 'social_id'];

	public function to_social() {
		return $this->belongsTo('App\Social');
	}
}
