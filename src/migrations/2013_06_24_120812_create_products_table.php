<?php

use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('products') )
		{
			Schema::create('products', function($table)
			{

				$table->engine = 'InnoDB';
			    $table->increments('id');

			    $table->string('title',255);
			    $table->string('slug',255);
			    $table->string('sku',255);
			    $table->text('description');
			    $table->decimal('price',7,2);
			    $table->string('url',255);
			    $table->boolean('enabled')->default(true);
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
		Schema::drop('products');
	}

}