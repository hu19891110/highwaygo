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
		Schema::create('orders', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('address_id')->unsigned();
			$table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
			$table->softDeletes();
			$table->timestamps();
			$table->string('mark')->default('');
			$table->enum('status', ['已取消', '尚未付款', '已付款', '已发货', '退款中', '已退款'])->default('尚未付款');
			$table->enum('pay_type', ['支付宝']);
			$table->string('number');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->double('price')->default(0);
			$table->string('trade_no')->nullable();
			$table->integer('delivery_id')->unsigned()->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('orders');
	}
}
