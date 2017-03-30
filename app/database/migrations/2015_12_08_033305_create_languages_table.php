<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLanguagesTable extends Migration {

	public function up()
	{
		Schema::create('languages', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('flag', 45);
			$table->string('language', 45);
			$table->string('available', 45);
			$table->integer('state');
		});
	}

	public function down()
	{
		Schema::drop('languages');
	}
}