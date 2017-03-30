<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLanguagesHotelTable extends Migration {

	public function up()
	{
		Schema::create('languages_hotel', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('language_id');
			$table->integer('hotel_id');
			$table->integer('state');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('languages_hotel');
	}
}