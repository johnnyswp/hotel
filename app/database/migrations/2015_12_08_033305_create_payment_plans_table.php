<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentPlansTable extends Migration {

	public function up()
	{
		Schema::create('payment_plans', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('plan_id');
			$table->integer('hotel_id');
			$table->integer('exchange_id');
			$table->datetime('date');
			$table->string('name_plan', 45);
			$table->integer('rooms');
			$table->float('pay');
			$table->datetime('expiration_old');
			$table->datetime('expiration');
			$table->string('pay_paypal', 45);
			$table->integer('state');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('payment_plans');
	}
}