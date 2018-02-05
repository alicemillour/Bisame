<?php
namespace App\Services;

use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CorpusSeeder extends CsvSeeder {

    public function __construct($filename = 'corpora.csv') {
        $this->table = 'corpora';
        Log::debug(App::getLocale());
        $this->filename = $filename;
        $this->csv_delimiter = ";";
    }

    public function run() {
       
        // Recommended when importing larger CSVs
        DB::disableQueryLog();
        // Uncomment the below to wipe the table clean before populating
//        DB::table($this->table)->delete();
        parent::run();
    }

}
