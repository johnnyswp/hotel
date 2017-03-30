<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePromotionsTable extends Migration {

	public function up()
	{
		Schema::create('promotions', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('hotel_id');
			$table->float('price');
			$table->datetime('since');
			$table->datetime('until');
			$table->datetime('since_2');
			$table->datetime('until_2');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('promotions');
	}
}