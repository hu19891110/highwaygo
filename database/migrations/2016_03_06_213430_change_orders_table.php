<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeOrdersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('orders', function (Blueprint $table) {
			$table->string('mark')->default('');
			$table->enum('status', ['已取消', '尚未付款', '已付款', '已发货', '退款中', '已退款'])->default('尚未付款');
			$table->enum('pay_type', ['支付宝']);
			$table->string('number');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('orders', function (Blueprint $table) {
			$table->dropColumn('mark');
			$table->dropColumn('status');
			$table->dropColumn('pay_type');
			$table->dropColumn('number');
		});
	}
}
