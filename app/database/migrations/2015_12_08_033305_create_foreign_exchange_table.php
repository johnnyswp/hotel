<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForeignExchangeTable extends Migration {

	public function up()
	{
		Schema::create('foreign_exchange', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 45);
			$table->string('symbol', 45);
			$table->string('state', 45);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('foreign_exchange');
	}
}