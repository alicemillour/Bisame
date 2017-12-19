<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnDeleteCascadeToForeignKeyPostagAndWordToAnnotation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('annotations', function ($table) {
            $table->dropForeign('annotations_postag_id_foreign');
            $table->dropForeign('annotations_word_id_foreign');
            $table->foreign('postag_id')->references('id')->on('postags')
                ->onDelete('cascade');
            $table->foreign('word_id')->references('id')->on('words')
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
    // Schema::table('annotations', function ($table) {
    //         $table->dropForeign('annotations_postag_id_foreign');
    //         $table->dropForeign('annotations_word_id_foreign');
    //         $table->foreign('postag_id')->references('id')->on('postags');
    //         $table->foreign('word_id')->references('id')->on('words');
    // });
    }
}
