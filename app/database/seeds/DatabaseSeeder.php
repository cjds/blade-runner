<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		/*DB::table('question_tag')->delete();
		DB::table('tags')->delete();
	 	DB::table('answers')->delete();
    	DB::table('questions')->delete();
        DB::table('posts')->delete();
        DB::table('users')->delete();


		$this->call('UserTableSeeder');*/
		$this->call('PostSeeder');
	}

}