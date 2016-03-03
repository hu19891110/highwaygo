<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMobileMessagesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create(config('mobile.table', 'messages'), function (Blueprint $table) {
			$table->increments('id');
			$table->string('ip', 15)->index();
			$table->char('mobile', 11)->index();
			$table->char('token', config('mobile.token_length', 6))->index();
			$table->boolean('active')->default(false);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop(config('mobile.table', 'messages'));
	}
}
