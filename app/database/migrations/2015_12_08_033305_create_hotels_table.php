<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHotelsTable extends Migration {

	public function up()
	{
		Schema::create('hotels', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('city_id');
			$table->integer('exchange_id');
			$table->integer('language_id');
			$table->string('name', 45);
			$table->string('address', 100);
			$table->string('web', 45);
			$table->integer('room_plan');
			$table->date('expiration');
			$table->string('state', 45);
			$table->string('logo', 100);
			$table->integer('reception_orders');
			$table->integer('template_styles');
			$table->datetime('limit_time');
			$table->integer('inform_email');
			$table->integer('inform_sms');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('hotels');
	}
}