<?php

use Illuminate\Database\Seeder;
use App\Badge;

class BadgesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Badge::updateOrCreate(['key' => 'recipe','order'=>'1'],['required_value' => '1','image' => 'recipe-'.App::getLocale().'-1.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'2'],['required_value' => '2','image' => 'recipe-'.App::getLocale().'-2.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'3'],['required_value' => '3','image' => 'recipe-'.App::getLocale().'-3.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'4'],['required_value' => '5','image' => 'recipe-'.App::getLocale().'-4.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'5'],['required_value' => '8','image' => 'recipe-'.App::getLocale().'-5.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'6'],['required_value' => '12','image' => 'recipe-'.App::getLocale().'-6.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'7'],['required_value' => '17','image' => 'recipe-'.App::getLocale().'-7.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'8'],['required_value' => '23','image' => 'recipe-'.App::getLocale().'-8.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'9'],['required_value' => '30','image' => 'recipe-'.App::getLocale().'-9.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'10'],['required_value' => '40','image' => 'recipe-'.App::getLocale().'-10.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'11'],['required_value' => '50','image' => 'recipe-'.App::getLocale().'-11.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'12'],['required_value' => '75','image' => 'recipe-'.App::getLocale().'-12.svg']);

        Badge::updateOrCreate(['key' => 'anecdote','order'=>'1'],['required_value' => '1','image' => 'anecdote-'.App::getLocale().'-1.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'2'],['required_value' => '2','image' => 'anecdote-'.App::getLocale().'-2.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'3'],['required_value' => '3','image' => 'anecdote-'.App::getLocale().'-3.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'4'],['required_value' => '5','image' => 'anecdote-'.App::getLocale().'-4.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'5'],['required_value' => '8','image' => 'anecdote-'.App::getLocale().'-5.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'6'],['required_value' => '12','image' => 'anecdote-'.App::getLocale().'-6.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'7'],['required_value' => '17','image' => 'anecdote-'.App::getLocale().'-7.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'8'],['required_value' => '23','image' => 'anecdote-'.App::getLocale().'-8.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'9'],['required_value' => '30','image' => 'anecdote-'.App::getLocale().'-9.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'10'],['required_value' => '40','image' => 'anecdote-'.App::getLocale().'-10.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'11'],['required_value' => '50','image' => 'anecdote-'.App::getLocale().'-11.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'12'],['required_value' => '75','image' => 'anecdote-'.App::getLocale().'-12.svg']);

        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'1'],['required_value' => '1','image' => 'alternativ-text-'.App::getLocale().'-1.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'2'],['required_value' => '2','image' => 'alternativ-text-'.App::getLocale().'-2.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'3'],['required_value' => '3','image' => 'alternativ-text-'.App::getLocale().'-3.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'4'],['required_value' => '5','image' => 'alternativ-text-'.App::getLocale().'-4.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'5'],['required_value' => '8','image' => 'alternativ-text-'.App::getLocale().'-5.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'6'],['required_value' => '12','image' => 'alternativ-text-'.App::getLocale().'-6.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'7'],['required_value' => '17','image' => 'alternativ-text-'.App::getLocale().'-7.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'8'],['required_value' => '23','image' => 'alternativ-text-'.App::getLocale().'-8.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'9'],['required_value' => '30','image' => 'alternativ-text-'.App::getLocale().'-9.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'10'],['required_value' => '40','image' => 'alternativ-text-'.App::getLocale().'-10.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'11'],['required_value' => '50','image' => 'alternativ-text-'.App::getLocale().'-11.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'12'],['required_value' => '75','image' => 'alternativ-text-'.App::getLocale().'-12.svg']);

        Badge::updateOrCreate(['key' => 'annotation','order'=>'1'],['required_value' => '1','image' => 'annotation-'.App::getLocale().'-1.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'2'],['required_value' => '10','image' => 'annotation-'.App::getLocale().'-2.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'3'],['required_value' => '25','image' => 'annotation-'.App::getLocale().'-3.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'4'],['required_value' => '50','image' => 'annotation-'.App::getLocale().'-4.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'5'],['required_value' => '75','image' => 'annotation-'.App::getLocale().'-5.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'6'],['required_value' => '100','image' => 'annotation-'.App::getLocale().'-6.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'7'],['required_value' => '150','image' => 'annotation-'.App::getLocale().'-7.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'8'],['required_value' => '200','image' => 'annotation-'.App::getLocale().'-8.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'9'],['required_value' => '300','image' => 'annotation-'.App::getLocale().'-9.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'10'],['required_value' => '500','image' => 'annotation-'.App::getLocale().'-10.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'11'],['required_value' => '750','image' => 'annotation-'.App::getLocale().'-11.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'12'],['required_value' => '1000','image' => 'annotation-'.App::getLocale().'-12.svg']);

        Badge::updateOrCreate(['key' => 'postag','order'=>'1'],['required_value_string' => 'ADJ','image' => 'postag-'.App::getLocale().'-1.svg']);
        Badge::updateOrCreate(['key' => 'postag','order'=>'2'],['required_value_string' => 'ADP','image' => 'postag-'.App::getLocale().'-2.svg']);
        Badge::updateOrCreate(['key' => 'postag','order'=>'3'],['required_value_string' => 'ADV','image' => 'postag-'.App::getLocale().'-3.svg']);
        Badge::updateOrCreate(['key' => 'postag','order'=>'4'],['required_value_string' => 'AUX','image' => 'postag-'.App::getLocale().'-4.svg']);
        Badge::updateOrCreate(['key' => 'postag','order'=>'5'],['required_value_string' => 'CONJ','image' => 'postag-'.App::getLocale().'-5.svg']);
        Badge::updateOrCreate(['key' => 'postag','order'=>'6'],['required_value_string' => 'DET','image' => 'postag-'.App::getLocale().'-6.svg']);
        Badge::updateOrCreate(['key' => 'postag','order'=>'7'],['required_value_string' => 'PART','image' => 'postag-'.App::getLocale().'-7.svg']);
        Badge::updateOrCreate(['key' => 'postag','order'=>'8'],['required_value_string' => 'PRON','image' => 'postag-'.App::getLocale().'-3.svg']);
        Badge::updateOrCreate(['key' => 'postag','order'=>'9'],['required_value_string' => 'SCONJ','image' => 'postag-'.App::getLocale().'-4.svg']);

        Badge::updateOrCreate(['key' => 'free-text','order'=>'1'],['required_value' => '1','image' => 'free-text-'.App::getLocale().'-1.svg']);
        Badge::updateOrCreate(['key' => 'free-text','order'=>'2'],['required_value' => '2','image' => 'free-text-'.App::getLocale().'-2.svg']);
        Badge::updateOrCreate(['key' => 'free-text','order'=>'3'],['required_value' => '3','image' => 'free-text-'.App::getLocale().'-3.svg']);
        Badge::updateOrCreate(['key' => 'free-text','order'=>'4'],['required_value' => '5','image' => 'free-text-'.App::getLocale().'-4.svg']);
        Badge::updateOrCreate(['key' => 'free-text','order'=>'5'],['required_value' => '8','image' => 'free-text-'.App::getLocale().'-5.svg']);
        Badge::updateOrCreate(['key' => 'free-text','order'=>'6'],['required_value' => '12','image' => 'free-text-'.App::getLocale().'-6.svg']);
        Badge::updateOrCreate(['key' => 'free-text','order'=>'7'],['required_value' => '17','image' => 'free-text-'.App::getLocale().'-7.svg']);
        Badge::updateOrCreate(['key' => 'free-text','order'=>'8'],['required_value' => '23','image' => 'free-text-'.App::getLocale().'-8.svg']);
        Badge::updateOrCreate(['key' => 'free-text','order'=>'9'],['required_value' => '30','image' => 'free-text-'.App::getLocale().'-9.svg']);
        Badge::updateOrCreate(['key' => 'free-text','order'=>'10'],['required_value' => '40','image' => 'free-text-'.App::getLocale().'-10.svg']);
        Badge::updateOrCreate(['key' => 'free-text','order'=>'11'],['required_value' => '50','image' => 'free-text-'.App::getLocale().'-11.svg']);
        Badge::updateOrCreate(['key' => 'free-text','order'=>'12'],['required_value' => '75','image' => 'free-text-'.App::getLocale().'-12.svg']);

        Badge::updateOrCreate(['key' => 'poem','order'=>'1'],['required_value' => '1','image' => 'poem-'.App::getLocale().'-1.svg']);
        Badge::updateOrCreate(['key' => 'poem','order'=>'2'],['required_value' => '2','image' => 'poem-'.App::getLocale().'-2.svg']);
        Badge::updateOrCreate(['key' => 'poem','order'=>'3'],['required_value' => '3','image' => 'poem-'.App::getLocale().'-3.svg']);
        Badge::updateOrCreate(['key' => 'poem','order'=>'4'],['required_value' => '5','image' => 'poem-'.App::getLocale().'-4.svg']);
        Badge::updateOrCreate(['key' => 'poem','order'=>'5'],['required_value' => '8','image' => 'poem-'.App::getLocale().'-5.svg']);
        Badge::updateOrCreate(['key' => 'poem','order'=>'6'],['required_value' => '12','image' => 'poem-'.App::getLocale().'-6.svg']);
        Badge::updateOrCreate(['key' => 'poem','order'=>'7'],['required_value' => '17','image' => 'poem-'.App::getLocale().'-7.svg']);
        Badge::updateOrCreate(['key' => 'poem','order'=>'8'],['required_value' => '23','image' => 'poem-'.App::getLocale().'-8.svg']);
        Badge::updateOrCreate(['key' => 'poem','order'=>'9'],['required_value' => '30','image' => 'poem-'.App::getLocale().'-9.svg']);
        Badge::updateOrCreate(['key' => 'poem','order'=>'10'],['required_value' => '40','image' => 'poem-'.App::getLocale().'-10.svg']);
        Badge::updateOrCreate(['key' => 'poem','order'=>'11'],['required_value' => '50','image' => 'poem-'.App::getLocale().'-11.svg']);
        Badge::updateOrCreate(['key' => 'poem','order'=>'12'],['required_value' => '75','image' => 'poem-'.App::getLocale().'-12.svg']);

        Badge::updateOrCreate(['key' => 'proverb','order'=>'1'],['required_value' => '1','image' => 'recipe-'.App::getLocale().'-1.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'2'],['required_value' => '2','image' => 'recipe-'.App::getLocale().'-2.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'3'],['required_value' => '3','image' => 'recipe-'.App::getLocale().'-3.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'4'],['required_value' => '5','image' => 'recipe-'.App::getLocale().'-4.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'5'],['required_value' => '8','image' => 'recipe-'.App::getLocale().'-5.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'6'],['required_value' => '12','image' => 'recipe-'.App::getLocale().'-6.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'7'],['required_value' => '17','image' => 'recipe-'.App::getLocale().'-7.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'8'],['required_value' => '23','image' => 'recipe-'.App::getLocale().'-8.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'9'],['required_value' => '30','image' => 'recipe-'.App::getLocale().'-9.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'10'],['required_value' => '40','image' => 'recipe-'.App::getLocale().'-10.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'11'],['required_value' => '50','image' => 'recipe-'.App::getLocale().'-11.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'12'],['required_value' => '75','image' => 'recipe-'.App::getLocale().'-12.svg']);

    }
}
