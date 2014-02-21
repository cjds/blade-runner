<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserOpenIdsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_open_ids', function(Blueprint $table) {
			$table->increments('id');
			$table->string('identity');
			$table->string('openid');
			$table->string('server');
			$table->timestamps();
			$table->index('openid');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_open_ids');
	}

}
