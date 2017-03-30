<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNamesCategoryMenuTable extends Migration {

	public function up()
	{
		Schema::create('names_category_menu', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('category_menu_id');
			$table->integer('language_id');
			$table->string('name', 45);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('names_category_menu');
	}
}