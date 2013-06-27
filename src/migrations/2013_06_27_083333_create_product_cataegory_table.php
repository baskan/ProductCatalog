<?php

use Illuminate\Database\Migrations\Migration;

class CreateProductCataegoryTable extends Migration {

/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('product_categories') )
		{
			Schema::create('product_categories', function($table)
			{

				$table->engine = 'InnoDB';
				$table->increments('id');
			    $table->integer('product_id')->unsigned();
			    $table->integer('category_id')->unsigned();

				$table->foreign('product_id')
					->references('id')->on('products')
					->onDelete('cascade');

				$table->foreign('category_id')
					->references('id')->on('categories')
					->onDelete('cascade');
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
		Schema::drop('product_categories');
	}

}