<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeConfidenceScoreTypeToFloatInAnnotation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE annotations MODIFY COLUMN confidence_score float');
    }

    public function down()
    {
        DB::statement('ALTER TABLE annotations MODIFY COLUMN confidence_score int');
    }   
}
