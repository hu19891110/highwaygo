<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('items', function (Blueprint $table) {
			$table->increments('id');
			// 物品名称
			$table->string('name', 20);
			// 简介
			$table->string('brief');
			// 详情
			$table->text('detail');
			// 物品分类
			$table->integer('classification_id')->unsigned();
			$table->foreign('classification_id')->references('id')->on('classifications')->onDelete('cascade');
			// 库存
			$table->integer('stock')->unsigned();
			// 价格
			$table->double('price');
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
		Schema::drop('items');
	}
}
