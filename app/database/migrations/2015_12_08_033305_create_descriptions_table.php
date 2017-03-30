<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDescriptionsTable extends Migration {

	public function up()
	{
		Schema::create('descriptions', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('menu_id');
			$table->integer('language_hotel_id');
			$table->string('description', 500);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('descriptions');
	}
}