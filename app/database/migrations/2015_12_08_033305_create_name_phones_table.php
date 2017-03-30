<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNamePhonesTable extends Migration {

	public function up()
	{
		Schema::create('name_phones', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 45);
			$table->integer('type_phone_id');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('name_phones');
	}
}