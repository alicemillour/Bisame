<?php

use Illuminate\Database\Seeder;
use App\AgeGroup;

class AgeGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AgeGroup::firstOrCreate(['slug' => 'dk']);
        AgeGroup::firstOrCreate(['slug' => '0-20']);
        AgeGroup::firstOrCreate(['slug' => '20-40']);
        AgeGroup::firstOrCreate(['slug' => '40-60']);
        AgeGroup::firstOrCreate(['slug' => '60-100']);
    }
}
