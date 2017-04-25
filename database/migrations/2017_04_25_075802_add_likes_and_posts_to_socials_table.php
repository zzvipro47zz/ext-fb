<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLikesAndPostsToSocialsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('socials', function (Blueprint $table) {
            $table->UnsignedInteger('likes')->default(0)->after('access_token');
            $table->UnsignedInteger('posts')->default(0)->after('likes');
		});
	}
}
