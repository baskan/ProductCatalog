<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('users') )
		{
			Schema::create('users', function($table)
			{

				$table->engine = 'InnoDB';
			    $table->increments('id');

			    $table->string('email',255);
			    $table->string('password',255);
			    $table->unique('email');

			    $table->string('first_name',255)->nullable()->default(null);
			    $table->string('last_name',255)->nullable()->default(null);
			    $table->boolean('is_admin')->default(false);
			    $table->dateTime('last_login')->nullable()->default(null);
			    $table->timestamps();

			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}