<?php

use Flynsarmy\CsvSeeder\CsvSeeder;

class AnnotationTableSeeder extends CsvSeeder {

    public function __construct()
    {
        $this->table = 'annotations';
        //$this->filename = base_path().'/database/seeds/csvs/wikipedia1_adjudication-UTF-8-2c.csv';
        $this->filename = base_path().'/database/seeds/csvs/exemple-recettes-annotation.csv';
        $this->csv_delimiter = ";";
    }

    public function run()
    {
        // Recommended when importing larger CSVs
        DB::disableQueryLog();

        // Uncomment the below to wipe the table clean before populating
        //DB::table($this->table)->truncate();

        parent::run();
    }
}