<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('votes', function(Blueprint $table) {
			$table->increments('votes_id');
			$table->unsignedInteger('user_id');
			$table->boolean('voteType');
			$table->unsignedInteger('post_id');
			$table->timestamps();

			$table->index('user_id');
			$table->foreign('user_id')->references('user_id')->on('users');

			$table->index('post_id');
			$table->foreign('post_id')->references('post_id')->on('posts');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('votes');
	}

}
