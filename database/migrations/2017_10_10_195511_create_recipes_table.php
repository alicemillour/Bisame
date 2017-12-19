<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('content');
            $table->text('commentary')->nullable();
            $table->unsignedSmallInteger('cooking_time_hour')->default(0);
            $table->unsignedSmallInteger('cooking_time_minute')->default(0);
            $table->unsignedSmallInteger('preparation_time_hour')->default(0);
            $table->unsignedSmallInteger('preparation_time_minute')->default(0);
            $table->unsignedSmallInteger('servings')->default(0);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('corpus_language_id');
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
        Schema::dropIfExists('recipes');
    }
}
