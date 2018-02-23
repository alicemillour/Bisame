<?php

use Illuminate\Database\Seeder;
use App\Language;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::updateOrCreate(['slug' => 'english']);
        Language::updateOrCreate(['slug' => 'french']);
        Language::updateOrCreate(['slug' => 'german']);
    }
}
