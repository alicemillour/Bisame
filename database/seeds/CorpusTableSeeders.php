<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class CorpusTableSeeder extends CsvSeeder {

    public function __construct()
    {
        $this->table = 'corpora';
        //$this->filename = base_path().'/database/seeds/csvs/wikipedia1_adjudication-UTF-8-2c.csv';
        $this->filename = base_path().'/database/seeds/csvs/corpora.csv';
        $this->csv_delimiter = ";";
    }

    public function run()
    {
        // Recommended when importing larger CSVs
        DB::disableQueryLog();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Uncomment the below to wipe the table clean before populating
        DB::table($this->table)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        parent::run();
    }
}