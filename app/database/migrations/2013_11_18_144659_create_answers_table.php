<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('answers', function(Blueprint $table) {
			$table->increments('post_id');
			$table->foreign('post_id')->references('post_id')->on('posts');

			$table->string('answer_body');
			$table->integer('answer_points')->default(0);
			$table->timestamps();

			
			$table->unsignedInteger('answer_question_id');
			$table->index('answer_question_id');
			$table->foreign('answer_question_id')->references('post_id')->on('questions');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('answers');
	}

}