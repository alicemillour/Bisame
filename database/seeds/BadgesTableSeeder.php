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
        Badge::updateOrCreate(['key' => 'recipe','order'=>'1'],['required_value' => '1','image' => 'muffin-1.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'2'],['required_value' => '2','image' => 'muffin-2.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'3'],['required_value' => '3','image' => 'muffin-3.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'4'],['required_value' => '5','image' => 'muffin-4.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'5'],['required_value' => '8','image' => 'muffin-5.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'6'],['required_value' => '12','image' => 'muffin-6.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'7'],['required_value' => '17','image' => 'muffin-7.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'8'],['required_value' => '23','image' => 'muffin-8.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'9'],['required_value' => '30','image' => 'muffin-9.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'10'],['required_value' => '40','image' => 'muffin-10.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'11'],['required_value' => '50','image' => 'muffin-11.svg']);
        Badge::updateOrCreate(['key' => 'recipe','order'=>'12'],['required_value' => '75','image' => 'muffin-12.svg']);

        Badge::updateOrCreate(['key' => 'anecdote','order'=>'1'],['required_value' => '1','image' => 'beer2-1.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'2'],['required_value' => '2','image' => 'beer2-2.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'3'],['required_value' => '3','image' => 'beer2-3.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'4'],['required_value' => '5','image' => 'beer2-4.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'5'],['required_value' => '8','image' => 'beer2-5.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'6'],['required_value' => '12','image' => 'beer2-6.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'7'],['required_value' => '17','image' => 'beer2-7.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'8'],['required_value' => '23','image' => 'beer2-8.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'9'],['required_value' => '30','image' => 'beer2-9.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'10'],['required_value' => '40','image' => 'beer2-10.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'11'],['required_value' => '50','image' => 'beer2-11.svg']);
        Badge::updateOrCreate(['key' => 'anecdote','order'=>'12'],['required_value' => '75','image' => 'beer2-12.svg']);

        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'1'],['required_value' => '1','image' => 'pretzel-1.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'2'],['required_value' => '2','image' => 'pretzel-2.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'3'],['required_value' => '3','image' => 'pretzel-3.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'4'],['required_value' => '5','image' => 'pretzel-4.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'5'],['required_value' => '8','image' => 'pretzel-5.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'6'],['required_value' => '12','image' => 'pretzel-6.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'7'],['required_value' => '17','image' => 'pretzel-7.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'8'],['required_value' => '23','image' => 'pretzel-8.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'9'],['required_value' => '30','image' => 'pretzel-9.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'10'],['required_value' => '40','image' => 'pretzel-10.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'11'],['required_value' => '50','image' => 'pretzel-11.svg']);
        Badge::updateOrCreate(['key' => 'alternativ-text','order'=>'12'],['required_value' => '75','image' => 'pretzel-12.svg']);

        Badge::updateOrCreate(['key' => 'annotation','order'=>'1'],['required_value' => '1','image' => 'graduate-1.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'2'],['required_value' => '10','image' => 'graduate-2.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'3'],['required_value' => '25','image' => 'graduate-3.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'4'],['required_value' => '50','image' => 'graduate-4.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'5'],['required_value' => '75','image' => 'graduate-5.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'6'],['required_value' => '100','image' => 'graduate-6.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'7'],['required_value' => '150','image' => 'graduate-7.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'8'],['required_value' => '200','image' => 'graduate-8.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'9'],['required_value' => '300','image' => 'graduate-9.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'10'],['required_value' => '500','image' => 'graduate-10.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'11'],['required_value' => '750','image' => 'graduate-11.svg']);
        Badge::updateOrCreate(['key' => 'annotation','order'=>'12'],['required_value' => '1000','image' => 'graduate-12.svg']);

        Badge::updateOrCreate(['key' => 'postag','order'=>'1'],['required_value_string' => 'ADJ','image' => 'laurel-1.svg']);
        Badge::updateOrCreate(['key' => 'postag','order'=>'2'],['required_value_string' => 'ADP','image' => 'laurel-2.svg']);
        Badge::updateOrCreate(['key' => 'postag','order'=>'3'],['required_value_string' => 'ADV','image' => 'laurel-3.svg']);
        Badge::updateOrCreate(['key' => 'postag','order'=>'4'],['required_value_string' => 'AUX','image' => 'laurel-4.svg']);
        Badge::updateOrCreate(['key' => 'postag','order'=>'5'],['required_value_string' => 'CONJ','image' => 'laurel-5.svg']);
        Badge::updateOrCreate(['key' => 'postag','order'=>'6'],['required_value_string' => 'DET','image' => 'laurel-6.svg']);
        Badge::updateOrCreate(['key' => 'postag','order'=>'7'],['required_value_string' => 'PART','image' => 'laurel-7.svg']);
        Badge::updateOrCreate(['key' => 'postag','order'=>'8'],['required_value_string' => 'PRON','image' => 'laurel-3.svg']);
        Badge::updateOrCreate(['key' => 'postag','order'=>'9'],['required_value_string' => 'SCONJ','image' => 'laurel-4.svg']);

    }
}
