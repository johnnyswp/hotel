<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCitiesTable extends Migration {

	public function up()
	{
		Schema::create('cities', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('province_id');
			$table->string('name', 45);
			$table->integer('state');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('cities');
	}
}