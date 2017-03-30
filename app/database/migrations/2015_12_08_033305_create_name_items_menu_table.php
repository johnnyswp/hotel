<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNameItemsMenuTable extends Migration {

	public function up()
	{
		Schema::create('name_items_menu', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('menu_id');
			$table->integer('language_id');
			$table->string('name', 45);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('name_items_menu');
	}
}