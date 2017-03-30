<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoomsTable extends Migration {

	public function up()
	{
		Schema::create('rooms', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('sector_id');
			$table->string('number_room', 45);
			$table->integer('state');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('rooms');
	}
}