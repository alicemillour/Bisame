<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnDeleteCascadeToForeignKeyGameAndSentenceToGameSentence extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::table('game_sentence', function ($table) {
            $table->dropForeign('game_sentence_game_id_foreign');
            $table->foreign('game_id')->references('id')->on('games')
                ->onDelete('cascade');
            $table->dropForeign('game_sentence_sentence_id_foreign');
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
    // Schema::table('game_sentence', function ($table) {
    //         $table->dropForeign('game_sentence_game_id_foreign');
    //         $table->foreign('game_id')->references('id')->on('games');
    //         $table->dropForeign('game_sentence_sentence_id_foreign');
    //         $table->foreign('sentence_id')->references('id')->on('sentences');
    // });
    }
}
