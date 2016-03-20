<?php

use Illuminate\Database\Seeder;
use App\Models\Postag;

class PostagTableSeeder extends Seeder
{

    public function __construct()
    {
        $this->table = 'postags';
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

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
                'name' => 'ADP'
            ]
        );
        Postag::create(
            [
                'name' => 'AUX'
            ]
        );
        Postag::create(
            [
                'name' => 'CONJ'
            ]
        );
        Postag::create(
            [
                'name' => 'DET'
            ]
        );
        Postag::create(
            [
                'name' => 'NUM'
            ]
        );
        Postag::create(
            [
                'name' => 'PRON'
            ]
        );
        Postag::create(
            [
                'name' => 'PART'
            ]
        );
        Postag::create(
            [
                'name' => 'SCONJ'
            ]
        );
        Postag::create(
            [
                'name' => 'PUNCT'
            ]
        );
        Postag::create(
            [
                'name' => 'SYM'
            ]
        );
        Postag::create(
            [
                'name' => 'X'
            ]
        );

        print("je suis la !");
        // Recommended when importing larger CSVs
        DB::disableQueryLog();

        // Uncomment the below to wipe the table clean before populating
        //DB::table($this->table)->truncate();
    }

}
