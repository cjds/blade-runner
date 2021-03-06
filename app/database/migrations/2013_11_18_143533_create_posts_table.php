<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table) {
			$table->increments('post_id');
			$table->string('post_type'); // 0 Question ... 1 answer
			$table->boolean('post_open')->default(true);
			$table->boolean('status')->default(true);//true--not deleted  false---deleted
			$table->unsignedInteger('creator_id');
			$table->unsignedInteger('editor_id')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->index('creator_id');
			$table->foreign('creator_id')->references('user_id')->on('users');
			$table->index('editor_id');
			$table->foreign('editor_id')->references('user_id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
	}

}