<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFreetextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freetexts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->varchar(400);
            $table->text('content');
            $table->text('commentary')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedSmallInteger('annotated')->default(0);
            $table->unsignedSmallInteger('validated')->default(0);
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('corpus_language_id');
            $table->date('deleted_at')->nullable();
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
        Schema::dropIfExists('freetexts');
    }
}
