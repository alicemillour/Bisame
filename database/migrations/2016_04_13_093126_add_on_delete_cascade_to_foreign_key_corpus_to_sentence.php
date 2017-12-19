<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnDeleteCascadeToForeignKeyCorpusToSentence extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
        public function up()
    {
        Schema::table('sentences', function ($table) {
            $table->dropForeign('sentences_corpus_id_foreign');
            $table->foreign('corpus_id')->references('id')->on('corpora')
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
        // Schema::table('sentences', function ($table) {
        //     $table->dropForeign('sentences_corpus_id_foreign');
        //     $table->foreign('corpus_id')->references('id')->on('corpora');
        // });
    }
}
