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
			    $table->string('slug',255)->nullable()->default(null);
			    $table->string('sku',255);
			    $table->text('description')->nullable()->default(null);
			    $table->decimal('price',7,2);
			    $table->string('url',255)->nullable()->default(null);
			    $table->boolean('enabled')->default(true);
			    $table->timestamps();
			    $table->unique('sku');
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
		Schema::drop('products');
	}

}