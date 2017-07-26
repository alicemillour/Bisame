<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class CorpusTableSeeder extends CsvSeeder {

    public function __construct() {
        $this->table = 'corpora';
        //$this->filename = base_path().'/database/seeds/csvs/wikipedia1_adjudication-UTF-8-2c.csv';
        $this->filename = base_path() . '/database/seeds/csvs/corpora.csv';
        $this->csv_delimiter = ";";
    }

    public function run() {
//        DB::table('corpora')->where('name', 'wikipedia1')->orWhere('name', 'wikipedia2')->orWhere('name', 'Hoflieferant_p53')
//                ->update(['is_training' => '1']);
        // Recommended when importing larger CSVs
//        DB::disableQueryLog();
        // Uncomment the below to wipe the table clean before populating
//        DB::table($this->table)->delete();
        parent::run();
    }

}
