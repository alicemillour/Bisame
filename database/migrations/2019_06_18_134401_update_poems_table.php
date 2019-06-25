<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePoemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
             
        Schema::table('poems', function (Blueprint $table) {
            $table->date('deleted_at')->nullable();
            $table->unsignedSmallInteger('annotated')->after('user_id')->default(0);
            $table->unsignedSmallInteger('validated')->after('user_id')->default(0);
            DB::statement('ALTER TABLE poems MODIFY COLUMN title varchar(400)');
        });    
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {        
        Schema::table('poems', function (Blueprint $table) {

            $table->dropColumn('annotated')->nullable();
            $table->dropColumn('validated')->nullable();
        });
    }
}
