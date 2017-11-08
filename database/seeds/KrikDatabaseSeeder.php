<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Word;

class KrikDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    Model::unguard();
    $this->call('UserTableSeeder');
    $this->call('PostagTableSeeder');
    $this->call('CorpusTableSeeder');
    $this->call('WordTableSeeder');
    $this->call('AnnotationTableSeeder');
    $this->call('AddFullNameToPostagsSeeder');
    Model::reguard();
    }
}