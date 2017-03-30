<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryMenuTable extends Migration {

	public function up()
	{
		Schema::create('category_menu', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('hotel_id');
			$table->integer('state');
			$table->integer('order');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('category_menu');
	}
}