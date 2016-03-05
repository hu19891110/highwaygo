<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeBannersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('banners', function (Blueprint $table) {
			$table->char('bgcolor', 7)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('banners', function (Blueprint $table) {
			$table->dropColumn('bgcolor');
		});
	}
}
