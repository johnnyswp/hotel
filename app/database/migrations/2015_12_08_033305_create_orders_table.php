<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('stay_id');
			$table->datetime('hour_order');
			$table->integer('state');
			$table->datetime('delivery_time');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}