<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpecialsDaysTable extends Migration {

	public function up()
	{
		Schema::create('specials_days', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('hotel_id');
			$table->date('date');
			$table->time('start_time_1');
			$table->time('end_time_1');
			$table->time('start_time_2');
			$table->time('end_time_2');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('specials_days');
	}
}