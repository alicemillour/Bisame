<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRecipeTables4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('sentences', function (Blueprint $table) {
            DB::statement('ALTER TABLE recipes MODIFY COLUMN title varchar(400)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('sentences', function (Blueprint $table) {
            DB::statement('ALTER TABLE recipes MODIFY COLUMN title varchar(400)');
        });
    }

}
