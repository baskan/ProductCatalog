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
		    $table->integer( 'attribute_set' );
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop( 'attribute_sets' );
		Schema::table( 'products' , function( $table )
		{
			$table->dropColumn( 'attribute_set' );
		});
	}

}