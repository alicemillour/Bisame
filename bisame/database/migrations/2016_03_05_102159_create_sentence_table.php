<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSentenceTable extends Migration {

	public function up()
	{
		Schema::create('sentence', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('corpus_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('sentence');
	}
}