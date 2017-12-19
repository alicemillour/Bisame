<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlternativeTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alternative_texts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('translatable_id');
            $table->string('translatable_attribute');
            $table->string('translatable_type');
            $table->text('value');
            $table->integer('offset_start');
            $table->integer('offset_end');
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
        Schema::dropIfExists('alternative_texts');
    }
}
