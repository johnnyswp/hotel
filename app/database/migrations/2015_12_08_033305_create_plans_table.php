<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlansTable extends Migration {

	public function up()
	{
		Schema::create('plans', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('exchange_id');
			$table->integer('room_quantity');
			$table->float('price');
			$table->integer('days');
			$table->integer('state');
			$table->string('plan_name', 45);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('plans');
	}
}