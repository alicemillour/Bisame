<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnDeleteCascadeToForeignKeySentenceToWord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('words', function ($table) {
            $table->dropForeign('words_sentence_id_foreign');
            $table->foreign('sentence_id')->references('id')->on('sentences')
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
       Schema::table('words', function ($table) {
            $table->dropForeign('words_sentence_id_foreign');
            $table->foreign('sentence_id')->references('id')->on('sentences');
        });
    }
}
