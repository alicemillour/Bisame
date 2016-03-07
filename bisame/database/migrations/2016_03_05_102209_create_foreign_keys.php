<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('sentence', function(Blueprint $table) {
			$table->foreign('corpus_id')->references('id')->on('corpus')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('sentence', function(Blueprint $table) {
			$table->dropForeign('sentence_corpus_id_foreign');
		});
	}
}