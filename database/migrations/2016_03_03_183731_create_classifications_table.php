<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClassificationsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('classifications', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 20);
			$table->integer('parent_id')->unsigned()->nullable();
			$table->foreign('parent_id')->references('id')->on('classifications')->onDelete('cascade');
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
		Schema::drop('classifications');
	}
}
