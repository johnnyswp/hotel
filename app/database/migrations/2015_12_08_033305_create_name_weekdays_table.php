<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNameWeekdaysTable extends Migration {

	public function up()
	{
		Schema::create('name_weekdays', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 50);
			$table->integer('weekday_id');
			$table->integer('language_id');
		});
	}

	public function down()
	{
		Schema::drop('name_weekdays');
	}
}