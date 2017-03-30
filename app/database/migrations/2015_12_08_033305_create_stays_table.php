<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStaysTable extends Migration {

	public function up()
	{
		Schema::create('stays', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('room_id');
			$table->integer('language_id');
			$table->string('name', 200);
			$table->time('start');
			$table->time('end');
			$table->integer('state');
			$table->string('email', 100);
			$table->string('phone', 45);
			$table->integer('report_email');
			$table->integer('report_sms');
			$table->string('key', 4);
			$table->string('token', 50);
			$table->datetime('closing_date');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('stays');
	}
}