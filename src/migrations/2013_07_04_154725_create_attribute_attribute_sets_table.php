<?php

use Illuminate\Database\Migrations\Migration;

class CreateAttributeAttributeSetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attribute_attribute_sets', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
		    $table->integer('attribute_id')->unsigned();
		    $table->integer('attribute_set_id')->unsigned();

			$table->foreign('attribute_id')
				->references('id')->on('attributes')
				->onDelete('cascade');

			$table->foreign('attribute_set_id')
				->references('id')->on('attribute_sets')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('attribute_attribute_sets');
	}

}