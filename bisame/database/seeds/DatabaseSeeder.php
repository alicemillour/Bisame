<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
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
    // $this->call('PostTableSeeder');
    // $this->call('TagTableSeeder');
        print("about to seed postag");
        $this->call('PostagTableSeeder');
        $this->call('CorpusTableSeeder');
        $this->call('SentenceTableSeeder');
        $this->call('WordTableSeeder');
        $this->call('AnnotationTableSeeder');
    Model::reguard();


    // for ($i = 1; $i < 41; $i++) {

    // DB::table('editeurs')->insert(['nom' => str_random(rand(8, 22))]);

    // DB::table('auteurs')->insert(['nom' => str_random(rand(8, 22))]);

    // }


    // for ($i = 1; $i < 81; $i++) {

    //     DB::table('livres')->insert([

    //         'titre' => str_random(rand(8, 22)),

    //         'editeur_id' => rand(1, 40)

    //     ]);

    // }


    // for ($i = 1; $i < 41; $i++) {

    //     $number = rand(2, 8);

    //     for ($j = 1; $j <= $number; $j++) {

    //         DB::table('auteur_livre')->insert([

    //             'livre_id' => rand(1, 40),

    //             'auteur_id' => $i

    //         ]);

    //     }
//}
    }
}