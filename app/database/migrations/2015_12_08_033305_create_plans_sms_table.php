<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlansSmsTable extends Migration {

	public function up()
	{
		Schema::create('plans_sms', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('exchange_id');
			$table->decimal('price');
			$table->integer('credits_sms');
			$table->integer('state');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('plans_sms');
	}
}