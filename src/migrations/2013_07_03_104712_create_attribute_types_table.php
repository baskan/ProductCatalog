<?php

use Illuminate\Database\Migrations\Migration;

class CreateAttributeTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attribute_types', function($table)
		{
			$table->increments( 'id' );
			$table->string( 'name' , 255 );
			$table->string( 'class' , 255 );	// The class to use for this type
		});
		Schema::table( 'attributes' , function( $table )
		{
		    $table->integer( 'attribute_type_id' )->unsigned()->nullable();
		    $table->dropColumn('type');
			$table->foreign('attribute_type_id')
			      ->references('id')->on('attribute_types')
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
		Schema::table( 'attributes' , function( $table )
		{
			$table->dropForeign('attributes_attribute_type_id_foreign');
			$table->dropColumn( 'attribute_type_id' );
		});
		Schema::drop( 'attribute_types' );
	}

}