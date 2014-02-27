<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUniversityQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('university_questions', function(Blueprint $table) {
			$table->increments('post_id');
			$table->unsignedInteger('question_marks');
			$table->unsignedInteger('question_subject_id');
			$table->unsignedInteger('question_module_id');
			$table->timestamps();
		
			$table->foreign('post_id')->references('post_id')->on('questions');
			$table->index('question_subject_id');
			$table->foreign('question_subject_id')->references('subject_id')->on('subjects');
			$table->index('question_module_id');
			$table->foreign('question_module_id')->references('module_id')->on('modules');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('university_questions');
	}

}