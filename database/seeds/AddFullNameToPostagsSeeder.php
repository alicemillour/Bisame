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
            'full_name' => 'Adjectif',
            'description' => 'E <b>scheeni</b> Frau /  D\'r Mann isch <b>gröü</b> / <b>kleiner</b> / Der Renner isch de <b>schnellscht</b> vùn àlle/ d erschta <b>druckta</b> Bibel / ìn <b>kochendem</b> Sàlzwàsser / sina <b>Stroßburger</b> Druckarèi / ìm <b>dritta</b> Stock '
         ]);
        DB::table('postags')->where('name','ADV')
                ->update([
            'full_name' => 'Adverbe'
         ]);
        DB::table('postags')->where('name','INTJ')
                ->update([
            'full_name' => 'Interjection',
            'description' => '<b>Bravo</b> !/ <b>O</b>, wie bin ich unglüecklich / <b>au</b>  '
         
         ]);
        DB::table('postags')->where('name','NOUN')
                ->update([
            'full_name' => 'Nom commun',
            'description' => 'das <b>Gewünschte </b>/ das <b>Reisen </b>/ <b>Sìcherheitsnorma </b> / <b>Volkstum-Museum </b>/ ein <b>Porsche </b>/ da <b>Israelita </b> vum Elsàss/ <b>Novamber </b>/ <b>Sundaa </b>/ Uf <b>Hochditsch </b>
'            
         ]);
        DB::table('postags')->where('name','PROPN')
                ->update([
            'full_name' => 'Nom propre',
            'description' => '<b>Auguste </b>,<b> Oberlin </b>,<b> Fifi </b>/<b> Peugeot</b>,<b> Kronenbourg </b>/<b> Contades </b>, <b>Straßburg</b>/ <b>Schwiz</b>, <b> Rhy</b>, <b> Alpe</b>'
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
            'full_name' => 'Pronom'
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
