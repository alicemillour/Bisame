<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePoemsFreetextsRecipesProverbTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE recipes MODIFY COLUMN content varchar(6000)');
        DB::statement('ALTER TABLE freetexts MODIFY COLUMN content varchar(6000)');
        DB::statement('ALTER TABLE poems MODIFY COLUMN content varchar(6000)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
