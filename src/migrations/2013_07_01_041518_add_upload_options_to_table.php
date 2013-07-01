<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUploadOptionsToTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('uploads', function(Blueprint $table)
		{
			$table->boolean('main_image')->default(false);
			$table->boolean('thumbnail_image')->default(false);
			$table->boolean('gallery')->default(true);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('uploads', function(Blueprint $table)
		{
			$table->dropColumn('main_image');
			$table->dropColumn('thumbnail_image');
			$table->dropColumn('gallery');
		});
	}

}