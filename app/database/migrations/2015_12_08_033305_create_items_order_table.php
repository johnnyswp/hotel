<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemsOrderTable extends Migration {

	public function up()
	{
		Schema::create('items_order', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('order_id');
			$table->integer('quantity');
			$table->decimal('asking_price');
			$table->integer('name_item_menu_id');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('items_order');
	}
}