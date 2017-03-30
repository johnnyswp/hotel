<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStandardTimesTable extends Migration {

	public function up()
	{
		Schema::create('standard_times', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('hotel_id');
			$table->integer('weekday_id');
			$table->time('start_time_1');
			$table->time('end_time_1');
			$table->time('start_time_2');
			$table->time('end_time_2');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('standard_times');
	}
}