<?php

use Illuminate\Database\Migrations\Migration;

class CreateCollectionIdInUploads extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'uploads' , function( $table )
        {
            $table->integer( 'collection_id' )->unsigned()->nullable();

            $table->foreign('collection_id')
                  ->references('id')->on('collections')
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
        Schema::table( 'uploads' , function( $table )
        {
            $table->dropForeign('uploads_collection_id_foreign');
            $table->dropColumn( 'collection_id' );
        });
    }

}