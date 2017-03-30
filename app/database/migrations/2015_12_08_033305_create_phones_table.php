<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePhonesTable extends Migration {

	public function up()
	{
		Schema::create('phones', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('hotel_id');
			$table->integer('type_phone_id');
			$table->string('number', 45);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('phones');
	}
}