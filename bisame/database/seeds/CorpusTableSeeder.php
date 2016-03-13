<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class CorpusTableSeeder extends CsvSeeder {

    public function __construct()
    {
        $this->table = 'word';
        $this->filename = base_path().'/database/seeds/csvs/wikipedia1_adjudication-UTF-8-2c.csv';
        $this->csv_delimiter = ";";
    }

    public function run()
    {
    	print("je suis la");
        // Recommended when importing larger CSVs
        DB::disableQueryLog();

        // Uncomment the below to wipe the table clean before populating
        DB::table($this->table)->truncate();

        parent::run();
    }
}