<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentSmsTable extends Migration {

	public function up()
	{
		Schema::create('payment_sms', function(Blueprint $table) {
			$table->increments('id');
			$table->string('paypal_operation_id', 45);
			$table->integer('plan_sms_id');
			$table->integer('exchange_id');
			$table->integer('hotel_id');
			$table->date('date');
			$table->integer('previous_balance_sms');
			$table->decimal('value_payment');
			$table->integer('back_balance_sms');
			$table->integer('charged_balance');
			$table->integer('state');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('payment_sms');
	}
}