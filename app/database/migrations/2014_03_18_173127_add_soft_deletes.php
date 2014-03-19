<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSoftDeletes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('questions', function($table) {
			$table->softDeletes();
		});

		Schema::table('answers', function($table) {
			$table->softDeletes();
		});

		Schema::table('votes', function($table) {
			$table->softDeletes();
		});

		Schema::table('university_questions', function($table) {
			$table->softDeletes();
		});



	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
	}

}
