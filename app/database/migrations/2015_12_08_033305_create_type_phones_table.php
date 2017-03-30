<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTypePhonesTable extends Migration {

	public function up()
	{
		Schema::create('type_phones', function(Blueprint $table) {
			$table->increments('id');
			$table->string('type', 45);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('type_phones');
	}
}