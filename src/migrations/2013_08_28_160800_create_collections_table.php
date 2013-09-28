<?php

use Illuminate\Database\Migrations\Migration;

class CreateCollectionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( !Schema::hasTable('collections') )
        {
            Schema::create('collections', function($table)
            {

                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('name' , 255);
                $table->string('slug' , 255);
                $table->string('url' , 255);
                $table->timestamps();
                $table->unique('url');
                $table->unique('slug');
            });
            Schema::table( 'products' , function( $table )
            {
                $table->integer( 'collection_id' )->unsigned()->nullable();

                $table->foreign('collection_id')
                      ->references('id')->on('collections')
                      ->onDelete('SET NULL'); // Set the attirbute set ID to null on the product if the attribute set is deleted

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
        Schema::table( 'products' , function( $table )
        {
            $table->dropForeign('products_collection_id_foreign');
            $table->dropColumn( 'collection_id' );
        });
        Schema::drop('collections');
    }

}