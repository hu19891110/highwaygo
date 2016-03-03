<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('addresses', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->char('mobile', 11)->index();
			$table->string('name', 20);
			$table->string('address');
			$table->boolean('active')->default(false);
			$table->softDeletes();
			$table->timestamps();
		});
		Schema::create('orders', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('address_id')->unsigned();
			$table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
			$table->softDeletes();
			$table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('orders');
		Schema::drop('addresses');
	}
}
