<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePositionToSentenceTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('sentences', function (Blueprint $table) {
            DB::statement('ALTER TABLE sentences MODIFY COLUMN position int(10)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('sentences', function (Blueprint $table) {
            DB::statement('ALTER TABLE sentences MODIFY COLUMN position tinyint(1)');
        });
    }

}
