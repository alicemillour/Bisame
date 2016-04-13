<?php
use Flynsarmy\CsvSeeder\CsvSeeder;

class PostagTableSeeder extends CsvSeeder
//class PostagTableSeeder extends Seeder
{

    public function __construct()
    {
        $this->table = 'postags';
        $this->filename = base_path().'/database/seeds/csvs/postags.csv';
        $this->csv_delimiter = ";";
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Uncomment the below to wipe the table clean before populating
        DB::table($this->table)->delete();
        // Recommended when importing larger CSVs
        DB::disableQueryLog();
        parent::run();
    }

}
