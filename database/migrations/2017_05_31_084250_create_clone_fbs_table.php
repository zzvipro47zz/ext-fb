<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCloneFbsTable extends Migration {
	public function up() {
		Schema::create('clone_fbs', function (Blueprint $table) {
			$table->increments('id');
			$table->string('email');
			$table->string('password');
			$table->string('access_token', 300)->nullable();
			$table->timestamps();
		});
	}

	public function down() {
		Schema::dropIfExists('clone_fbs');
	}
}
