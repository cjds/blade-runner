<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFlagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flags', function(Blueprint $table) {
			$table->increments('flag_id');
			$table->string('flag_reason');
			$table->string('flag_approved')->nullable();

			$table->unsignedInteger('creator_id');
			$table->index('creator_id');
			$table->foreign('creator_id')->references('user_id')->on('users');

			$table->unsignedInteger('moderator_id')->nullable();
			$table->index('moderator_id');
			$table->foreign('moderator_id')->references('user_id')->on('users');

			$table->unsignedInteger('post_id');
			$table->index('post_id');
			$table->foreign('post_id')->references('post_id')->on('posts');

			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('flags');
	}

}
