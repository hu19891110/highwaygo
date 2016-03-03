<?php

use Illuminate\Database\Migrations\Migration;

class ChangeUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('users', function ($table) {
			$table->string('portrait')->default('');
			$table->string('name', 20)->change();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('users', function ($table) {
			$table->dropSoftDeletes();
			$table->string('name')->change();
			$table->dropColumn('portrait');
		});
	}
}
