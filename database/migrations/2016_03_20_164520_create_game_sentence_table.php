<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameSentenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_sentence', function(Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('game_id')->unsigned()->nullable();
            $table->integer('sentence_id')->unsigned()->nullable();
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('sentence_id')->references('id')->on('sentences');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('game_sentence');
    }
}
