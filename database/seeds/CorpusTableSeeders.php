<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class CorpusTableSeeder extends CsvSeeder {

    public function __construct() {
        $this->table = 'corpora';
        $this->filename = base_path() . '/database/seeds/csvs/corpora.csv';
        $this->csv_delimiter = ";";
    }

    public function run() {
       
        // Recommended when importing larger CSVs
        Log::debug("hello");
        DB::disableQueryLog();
        // Uncomment the below to wipe the table clean before populating
//        DB::table($this->table)->delete();
        parent::run();
    }

}
