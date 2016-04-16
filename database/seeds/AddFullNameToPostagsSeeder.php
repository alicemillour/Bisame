<?php

use Illuminate\Database\Seeder;

class AddFullNameToPostagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('postags')->where('name','ADJ')
                ->update([
            'full_name' => 'Adjectif'
         ]);
        DB::table('postags')->where('name','ADV')
                ->update([
            'full_name' => 'Adverbe'
         ]);
        DB::table('postags')->where('name','INTJ')
                ->update([
            'full_name' => 'Interjection'
         ]);
        DB::table('postags')->where('name','NOUN')
                ->update([
            'full_name' => 'Nom commun'
         ]);
        DB::table('postags')->where('name','PROPN')
                ->update([
            'full_name' => 'Nom propre'
         ]);
        DB::table('postags')->where('name','VERB')
                ->update([
            'full_name' => 'Verbe'
         ]);
        DB::table('postags')->where('name','ADP')
                ->update([
            'full_name' => 'Préposition'
         ]);
        DB::table('postags')->where('name','AUX')
                ->update([
            'full_name' => 'Auxiliaire'
         ]);
        DB::table('postags')->where('name','CONJ')
                ->update([
            'full_name' => 'Conjonction'
         ]);
        DB::table('postags')->where('name','DET')
                ->update([
            'full_name' => 'Déterminant'
         ]);
        DB::table('postags')->where('name','NUM')
                ->update([
            'full_name' => 'Nombre'
         ]);
        DB::table('postags')->where('name','PRON')
                ->update([
            'full_name' => 'Adjectif'
         ]);
        DB::table('postags')->where('name','PART')
                ->update([
            'full_name' => 'Particule'
         ]);
        DB::table('postags')->where('name','SCONJ')
                ->update([
            'full_name' => 'Conjonction de subordination'
         ]);
        DB::table('postags')->where('name','PUNCT')
                ->update([
            'full_name' => 'Ponctuation'
         ]);
        DB::table('postags')->where('name','SYM')
                ->update([
            'full_name' => 'Symbole'
         ]);
        DB::table('postags')->where('name','X')
                ->update([
            'full_name' => 'Indéfini'
         ]);
    }
}
