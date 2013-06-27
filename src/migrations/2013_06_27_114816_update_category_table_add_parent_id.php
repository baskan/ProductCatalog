<?php

use Illuminate\Database\Migrations\Migration;

class UpdateCategoryTableAddParentId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('categories', function($table)
		{
		    $table->integer('parent_id')->unsigned()->nullable();
			$table->foreign('parent_id')
			      ->references('id')->on('categories')
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
		Schema::table('categories', function($table)
		{
		    $table->dropColumn('parent_id');
		    $table->dropIndex('categories_parent_id_foreign');
		});
	}

}