<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSentenceTable extends Migration {

	public function up()
	{
		Schema::create('sentences', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('corpus_id')->unsigned()->nullable();
			$table->foreign('corpus_id')->references('id')->on('corpora');
		});
	}

	public function down()
	{
		Schema::drop('sentences');
	}
}