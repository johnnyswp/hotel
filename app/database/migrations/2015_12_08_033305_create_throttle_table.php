<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateThrottleTable extends Migration {

	public function up()
	{
		Schema::create('throttle', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('ip_address')->nullable();
			$table->integer('attempts')->default('0');
			$table->tinyInteger('suspended')->default('0');
			$table->tinyInteger('banned')->default('0');
			$table->timestamp('last_attempt_at')->nullable();
			$table->timestamp('suspended_at')->nullable();
			$table->timestamp('banned_at')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('throttle');
	}
}