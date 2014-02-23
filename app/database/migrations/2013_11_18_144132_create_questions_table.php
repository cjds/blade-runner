<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questions', function(Blueprint $table) {
			//$table->engine = 'MyISAM';
			$table->increments('post_id');
			$table->string('question_title');
			$table->string('question_body');
			$table->string('question_modules');
			$table->integer('question_points')->default(0);
			$table->timestamps();
		
			$table->foreign('post_id')->references('post_id')->on('posts');

		});

	//	DB::statement('ALTER TABLE questions ADD FULLTEXT search(question_title, question_body)');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('questions', function($table) {
            $table->dropIndex('search');
        });

		Schema::drop('questions');
	}

}