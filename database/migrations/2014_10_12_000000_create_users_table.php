<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
	public function up() {
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('email');
			$table->string('password');
			$table->unsignedTinyInteger('role')->default(0)->comment('0: member, 1: admin');
			$table->rememberToken();
			$table->timestamps();
		});
	}

	public function down() {
		Schema::dropIfExists('users');
	}
}
