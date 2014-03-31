<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notes', function(Blueprint $table) {
			$table->increments('notes_id');
			$table->unsignedInteger('module_id');
			$table->string('file')->nullable();
			$table->longText('description')->nullable();
			$table->unsignedInteger('user_id');
			
			$table->timestamps();
			$table->softDeletes();

			$table->index('module_id');
			$table->foreign('module_id')->references('module_id')->on('modules');
			$table->index('user_id');
			$table->foreign('user_id')->references('user_id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('notes');
	}

}
