<?php

use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('categories') )
		{
			Schema::create('categories', function($table)
			{

				$table->engine = 'InnoDB';
			    $table->increments('id');

			    $table->string('name' , 255);
			    $table->string('slug' , 255)->nullable()->default(null);
			    $table->text('description')->nullable()->default(null);;
			    $table->string('url' , 255);
			    $table->boolean('enabled')->default(true);
			    $table->timestamps();
			    $table->unique('url');
			    $table->unique('slug');

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
		Schema::drop('categories');
	}

}