<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_profiles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->index();

			$table->string('avatar')->nullable();
			$table->string('profile_img')->nullable();
			$table->string('bio', 1000)->nullable();
			$table->string('twitter')->nullable();
			$table->string('website')->nullable();
			$table->integer('country_id')->nullable();
			$table->date('birthdate')->nullable();

			$table->string('signature', 1000)->nullable();
			$table->enum('gender', ['none', 'male', 'female']);

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
		Schema::drop('user_profiles');
	}

}
