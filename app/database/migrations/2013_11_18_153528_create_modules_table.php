<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('modules', function(Blueprint $table) {
			$table->increments('module_id');
			$table->string('module_name');
			$table->timestamps();

			$table->unsignedInteger('module_subject_id');
			$table->index('module_subject_id');
			$table->foreign('module_subject_id')->references('subject_id')->on('subjects');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('modules');
	}

}