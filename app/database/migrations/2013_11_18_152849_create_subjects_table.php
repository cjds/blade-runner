<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subjects', function(Blueprint $table) {
			$table->increments('subject_id');
			$table->string('subject_name');
			$table->string('subject_shortname');
			$table->integer('subject_sem');
			$table->timestamps();

			$table->unsignedInteger('subject_branch_id'); 	
			$table->index('subject_branch_id');
			$table->foreign('subject_branch_id')->references('branch_id')->on('branches');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('subjects');
	}

}