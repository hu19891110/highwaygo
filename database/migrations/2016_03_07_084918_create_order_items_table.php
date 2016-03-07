<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderItemsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('order_items', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('item_id')->unsigned();
			$table->foreign('item_id')->references('id')->on('items');
			$table->integer('order_id')->unsigned();
			$table->foreign('order_id')->references('id')->on('orders');
			$table->integer('count')->unsigned();
			$table->double('price')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('order_items');
	}
}
