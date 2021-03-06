<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function(Blueprint $table) {
			$table->increments('comment_id');
			$table->string('comment_body');
			$table->timestamps();

			$table->unsignedInteger('comment_post_id');
			$table->index('comment_post_id');
			$table->foreign('comment_post_id')->references('post_id')->on('posts');

			$table->unsignedInteger('comment_user_id');
			$table->index('comment_user_id');
			$table->foreign('comment_user_id')->references('user_id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('comments');
	}

}