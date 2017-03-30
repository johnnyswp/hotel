<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoomsSectorsTable extends Migration {

	public function up()
	{
		Schema::create('rooms_sectors', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('hotel_id');
			$table->string('name', 45);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('rooms_sectors');
	}
}