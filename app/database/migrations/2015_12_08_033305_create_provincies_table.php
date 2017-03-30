<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProvinciesTable extends Migration {

	public function up()
	{
		Schema::create('provincies', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('country_id');
			$table->string('name', 45);
			$table->integer('state');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('provincies');
	}
}