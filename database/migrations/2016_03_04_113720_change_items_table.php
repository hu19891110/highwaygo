<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeItemsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('items', function (Blueprint $table) {
			$table->unsignedTinyInteger('hot')->default(0); // 热卖指数基数
			$table->unsignedTinyInteger('recommend')->default(0); // 推荐指数基数
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('items', function (Blueprint $table) {
			$table->dropColumn('hot');
			$table->dropColumn('recommend');
		});
	}
}
