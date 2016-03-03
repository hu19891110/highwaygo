<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemCommentsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('item_comments', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('item_id')->unsigned();
			$table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
			$table->integer('order_id')->unsigned();
			$table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->string('content');
			$table->tinyInteger('star')->default(5)->unsigned();
			$table->string('reply')->nullable();
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
		Schema::drop('item_comments');
	}
}
