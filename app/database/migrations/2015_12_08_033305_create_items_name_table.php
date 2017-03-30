<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemsNameTable extends Migration {

	public function up()
	{
		Schema::create('items_name', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('language_id');
			$table->integer('promotion_id');
			$table->string('name', 45);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('items_name');
	}
}