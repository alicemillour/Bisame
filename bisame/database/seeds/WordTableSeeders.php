<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class WordTableSeeder extends CsvSeeder {

    public function __construct()
    {

        print("je suis la");
        $this->table = 'words';
        //$this->filename = base_path().'/database/seeds/csvs/wikipedia1_adjudication-UTF-8-2c.csv';
        $this->filename = base_path().'/database/seeds/csvs/exemple-recettes.csv';
        $this->csv_delimiter = ";";
    }

    public function run()
    {
    	print("je suis la");
        // Recommended when importing larger CSVs
        DB::disableQueryLog();

        // Uncomment the below to wipe the table clean before populating
        //DB::table($this->table)->truncate();

        parent::run();
    }
}