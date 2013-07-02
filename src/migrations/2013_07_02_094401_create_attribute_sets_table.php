<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeSetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attribute_sets', function($table)
		{
			$table->increments( 'id' );
			$table->string( 'name' , 255 );	// The name of the attribute set
			$table->timestamps();
		});
		Schema::table( 'products' , function( $table )
		{
		    $table->integer( 'attribute_set_id' )->unsigned()->nullable();

			$table->foreign('attribute_set_id')
			      ->references('id')->on('attribute_sets')
			      ->onDelete('SET NULL'); // Set the attirbute set ID to null on the product if the attribute set is deleted

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table( 'products' , function( $table )
		{
			$table->dropForeign('products_attribute_set_id_foreign');
			$table->dropColumn( 'attribute_set_id' );
		});
		Schema::drop( 'attribute_sets' );
	}

}