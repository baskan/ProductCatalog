<?php

use Illuminate\Database\Migrations\Migration;

class CreateProductsAttributesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products_attributes', function($table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
		    $table->integer('product_id')->unsigned();
		    $table->integer('attribute_id')->unsigned();
		    $table->text('value');

			$table->foreign('product_id')
				->references('id')->on('products')
				->onDelete('cascade');

			$table->foreign('attribute_id')
				->references('id')->on('attributes')
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
		Schema::drop('products_attributes');
	}

}