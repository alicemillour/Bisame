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
        Schema::create('gameSentences', function (Blueprint $table) {
        $table->increments('id');
            $table->integer('sentence_id')->unsigned()->nullable();
            $table->integer('game_id')->unsigned()->nullable();
        $table->foreign('sentence_id')->references('id')->on('sentences');
        $table->foreign('game_id')->references('id')->on('games');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('gameSentences');
    }
}
