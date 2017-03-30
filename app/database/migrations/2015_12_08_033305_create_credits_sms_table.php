<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCreditsSmsTable extends Migration {

	public function up()
	{
		Schema::create('credits_sms', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('hotel_id');
			$table->integer('credits');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('credits_sms');
	}
}