<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTagTable extends Migration {

    public function up()
    {
		Schema::create('post_tag', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('post_id')->unsigned();
			$table->integer('tag_id')->unsigned();
			$table->foreign('post_id')->references('id')->on('posts')
						->onDelete('restrict')
						->onUpdate('restrict');

			$table->foreign('tag_id')->references('id')->on('tags')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('post_tag', function(Blueprint $table) {
			$table->dropForeign('post_tag_post_id_foreign');
			$table->dropForeign('post_tag_tag_id_foreign');
		});

		Schema::drop('post_tag');
	}
}