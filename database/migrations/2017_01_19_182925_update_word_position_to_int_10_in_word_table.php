<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateWordPositionToInt10InWordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('words', function (Blueprint $table) {
            DB::statement('ALTER TABLE words MODIFY COLUMN position int(10)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('words', function (Blueprint $table) {
            DB::statement('ALTER TABLE words MODIFY COLUMN position tinyint(1)');
        });
    }
}
