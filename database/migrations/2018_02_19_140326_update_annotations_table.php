<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class UpdateAnnotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('annotations', function ($table) {
            $table->unsignedSmallInteger('points_not_seen')->after('postag_id')->default(0);
            $table->unsignedSmallInteger('points')->after('postag_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Schema::drop('users');
    }
}
