<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialsTable extends Migration {
	public function up() {
		Schema::create('socials', function (Blueprint $table) {
			$table->increments('id');
			$table->string('provider_uid', 20)->unique();
			$table->string('name');
			$table->string('email')->nullable();
			$table->string('phone')->nullable();
			$table->unsignedTinyInteger('gender')->comment('0: Nữ - 1: Nam');
			$table->string('password');
			$table->string('link');
			$table->UnsignedInteger('likes')->default(0);
			$table->UnsignedInteger('subs')->default(0);
			$table->string('access_token', 300);
			$table->string('cookie', 255);
			$table->string('provider');
			$table->unsignedInteger('user_id');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->timestamps();
		});
	}

	public function down() {
		Schema::dropIfExists('socials');
	}
}
