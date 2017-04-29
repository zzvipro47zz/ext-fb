<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('socials', function (Blueprint $table) {
			$table->increments('id');
			$table->string('provider_user_id', 20);
			$table->string('access_token');
			$table->UnsignedInteger('likes')->default(0);
            $table->UnsignedInteger('posts')->default(0);
			$table->string('provider');
			$table->unsignedInteger('user_id');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('socials');
	}
}
