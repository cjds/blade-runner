<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSuggestedEditsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('suggested_edits', function(Blueprint $table) {
			$table->increments('suggested_edits_id');
			$table->string('editExplanation');
			$table->string('post_type'); // 0 Question ... 1 answer
			$table->integer('status')->default(0); //0 undecided 1 accepted 2 rejected
			$table->integer('approvals')->default(0);
			$table->timestamps();

			$table->unsignedInteger('moderator_id')->nullable();
			$table->index('moderator_id');
			$table->foreign('moderator_id')->references('user_id')->on('users');

			$table->unsignedInteger('original_post_id');
			$table->index('original_post_id');
			$table->foreign('original_post_id')->references('post_id')->on('posts');

			$table->unsignedInteger('question_editor_id');			
			$table->index('question_editor_id');
			$table->foreign('question_editor_id')->references('user_id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('suggested_edits');
	}

}