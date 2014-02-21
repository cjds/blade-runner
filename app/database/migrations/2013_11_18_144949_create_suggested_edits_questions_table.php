<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSuggestedEditsQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('suggested_edits_questions', function(Blueprint $table) {
			$table->increments('suggested_edits_id');
			$table->string('suggested_edits_question_title');
			$table->string('suggested_edits_question_body');
			$table->string('suggested_edits_question_tags'); // comma separated values of tag IDs
			$table->string('suggested_edits_question_modules'); // think this may get deleted
			$table->timestamps();

			$table->foreign('suggested_edits_id')->references('suggested_edits_id')->on('suggested_edits');

			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('suggested_edits_questions');
	}

}