<?php

use Illuminate\Database\Seeder;
use App\Models\\Corpus;

class CorpusTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('corpus')->delete();

		// CorpusTableSeeder
		Corpus::create(array(
				'name' => 'wikipedia'
			));
	}
}