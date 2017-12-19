<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeScoreTypeToFloatInUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        DB::statement('ALTER TABLE users MODIFY COLUMN score float');
    }

    // public function down()
    // {
    //     DB::statement('ALTER TABLE users MODIFY COLUMN score int');
    // }   

    }
