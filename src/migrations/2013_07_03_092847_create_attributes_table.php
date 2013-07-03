<?php

use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create( 'attributes' , function($table)
		{
			$table->increments( 'id' );
			$table->string( 'type' , 255 );	// The name of the attribute set
			$table->string( 'key' , 255 );	// The name of the attribute set
			$table->string( 'name' , 255 );	// The name of the attribute set
			$table->timestamps();
			$table->unique('key');
			$table->unique('name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop( 'attributes' );
	}

}