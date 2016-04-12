<?php
use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Database\Seeder;
use App\Models\Postag;

//class PostagTableSeeder extends CsvSeeder
class PostagTableSeeder extends Seeder
{

    public function __construct()
    {
        $this->table = 'postags';
        //$this->filename = base_path().'/database/seeds/csvs/postags.csv';
        //$this->csv_delimiter = ";";
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Uncomment the below to wipe the table clean before populating
        //DB::table($this->table)->truncate();

        Postag::create(
            [
                'name' => 'ADJ'
            ]
        );
        Postag::create(
            [
                'name' => 'ADV'
            ]
        );

        Postag::create(
            [
                'name' => 'INTJ'
            ]
        );

        Postag::create(
            [
                'name' => 'NOUN'
            ]
        );
        Postag::create(
        [
            'name' => 'PROPN'
        ]
        );
        Postag::create(
            [
                'name' => 'VERB'
            ]
        );

        Postag::create(
            [
                'name' => 'ADP',
                'category' => 'closed'
            ]
        );
        Postag::create(
            [
                'name' => 'AUX',
                'category' => 'closed'
            ]
        );
        Postag::create(
            [
                'name' => 'CONJ',
                'category' => 'closed'
            ]
        );
        Postag::create(
            [
                'name' => 'DET',
                'category' => 'closed'
            ]
        );
        Postag::create(
            [
                'name' => 'NUM',
                'category' => 'closed'
            ]
        );
        Postag::create(
            [
                'name' => 'PRON',
                'category' => 'closed'
            ]
        );
        Postag::create(
            [
                'name' => 'PART',
                'category' => 'closed'
            ]
        );
        Postag::create(
            [
                'name' => 'SCONJ',
                'category' => 'closed'
            ]
        );
        Postag::create(
            [
                'name' => 'PUNCT',
                'category' => 'other'
            ]
        );
        Postag::create(
            [
                'name' => 'SYM',
                'category' => 'other'
            ]
        );
        Postag::create(
            [
                'name' => 'X',
                'category' => 'other'
            ]
        );

        // Recommended when importing larger CSVs
        DB::disableQueryLog();


    }

}
