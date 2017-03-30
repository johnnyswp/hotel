<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePromotionsProductsTable extends Migration {

	public function up()
	{
		Schema::create('promotions_products', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('menu_id');
			$table->string('number_item', 45);
			$table->integer('promotion_id');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('promotions_products');
	}
}