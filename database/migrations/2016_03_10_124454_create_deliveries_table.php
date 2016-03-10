<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDeliveriesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('deliveries', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 20);
			$table->integer('order_id')->unsigned();
			$table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
			$table->string('number');
			$table->timestamps();
			$table->softDeletes();
		});
		Schema::table('orders', function (Blueprint $table) {
			$table->foreign('delivery_id')->references('id')->on('deliveries');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('orders', function (Blueprint $table) {
			$table->dropForeign('delivery_id');
		});
		Schema::drop('deliveries');
	}
}
