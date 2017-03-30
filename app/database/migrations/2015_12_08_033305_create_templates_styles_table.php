<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTemplatesStylesTable extends Migration {

	public function up()
	{
		Schema::create('templates_styles', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 45);
			$table->string('template', 45);
			$table->integer('state');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('templates_styles');
	}
}