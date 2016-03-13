<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('word', function(Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('value');
            $table->integer('sentence_id')->unsigned()->nullable();;
            $table->foreign('sentence_id')->references('id')->on('sentence');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('word');
    }
}
