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
            'description' => '-Im <b>fréje</b> Land <br>
-Uff em <b>truckene</b> Bodde.<br>
-Ich mëcht e Kilo <b>zittigi</b> Äpfel<br>
-D’Äpfel sín <b>zitti(g)</b>.<br>
-Si ältschta <b>bekànnta</b> Druckwark<br>
-Er hét <b>grossi</b> ; er hétt e <b>schéni</b><br><br>
<u>ATTENTION</u> : Ne pas confondre avec ADV (Adverbes) : <br>
-S Gschaft vum Johannes Mentelin hàt <b>schnall</b> Erfolg bikumma<br>
-Èr hétt <b>schén</b> gspìelt.'
         ]);
        DB::table('postags')->where('name','ADV')
                ->update([
            'full_name' => 'Adverbe',
            'description' =>  '-Ìm Gsàmta hàt\'r <b>ungfahr</b> 40 Biacher unter Duck gmàcht.<br>
-<b>Wann</b> kommscht du ?<br>
-Bi deana Musika isch o Ibrahim Ferrer <b>dabei</b>  gsi.<br>
-Èr hétt <b>schén</b> gspìelt.<br>
-<u>Nìmm</u> : Ar ìsch uffem Kirchhof vu dr St.-Michaels-Kapelle ( wo\'s <b>nìmm</b> gìtt ) vergràwa. <br>
-Cas <u>Wo / wenn</u> :
Ma weiß nìt gnàui , <b>wo</b> un <b>wenn</b> àss er d Technik vum Büechdrucka glehrt hàt. <br>
-<u>Equivalents alsaciens des adverbes pronominaux allemands</u> : dafür, dabei, deswegen, trotzdem, hierauf, hierzu, hiermit :<br>
 &nbsp;&nbsp;&nbsp;&nbsp;-wo bim Notàr nìt <b>derbi</b> gsìì ìsch<br>
 &nbsp;&nbsp;&nbsp;&nbsp;-un hàt <b>derfer</b> a Gschaftsààteil vum Museum bikumma <br><br>
Mais <u>ATTENTION</u> : <br>
1. <u>Wenn</u> : conjonction de subordination (SCONJ) dans le sens de &quot si &quot : <br>
<b>Wenn</b> dàs stìmmt, war àlso dr Johannes Mentelin , noch vor em Heinrich Eggestein , dr erscht Büechdrucker vu Stroßburri gsìì. <br>
2. <u>Wo</u> : pronom (PRON) lorsqu’il est utilisé comme pronom relatif (qui/que):<br>
Dr erscht Druck <b>wo</b> ma vum Nàma Mentelin erfàhrt ìsch „ Augustinus “ Tractatus de arte praedicandi, ìm Johr 1465 .'

         ]);
        DB::table('postags')->where('name','INTJ')
                ->update([
            'full_name' => 'Interjection',
            'description' => '-<b>Ohü</b> ! Diss klingt m\'r zue gelehrt! <br>-<b>Bravo</b> ! <br> -<b>O</b>, wie bin ich unglüecklich <br> -<b>au</b>  '
         
         ]);
        DB::table('postags')->where('name','NOUN')
                ->update([
            'full_name' => 'Nom commun',
            'description' => '-das <b>Gewünschte</b><br> -das <b>Reisen </b><br> -<b>Sìcherheitsnorma </b><br> -<b>Volkstum-Museum </b><br> -ein <b>Porsche </b><br> -da <b>Israelita </b> vum Elsàss<br> -<b>Novamber </b>, <b>Sundaa </b><br> -Uf <b>Hochditsch </b>
'            
         ]);
        DB::table('postags')->where('name','PROPN')
                ->update([
            'full_name' => 'Nom propre',
            'description' => '-<b>Auguste </b>,<b> Oberlin </b>,<b> Fifi </b> <br>-<b>Peugeot</b>,<b> Kronenbourg </b><br>-<b>Contades </b>, <b>Straßburg</b><br>-<b>Schwiz</b>, <b> Rhy</b>, <b> Alpe</b>'
         ]);
        DB::table('postags')->where('name','VERB')
                ->update([
            'full_name' => 'Verbe',
            'description' => '-Pan <b>spilt</b> uf de Syrinx (Panflöte) und <b>tanzt</b> mit de Nymphe.
<br><br>
<u>ATTENTION</u> Verbes à particules : üssnùtze (exploiter) <br>
-Her <b>nùtzt</b> mich <b>üss (PART)</b>. (Il m’exploite) <br>
-Er het mich <b>üssgenùtzt</b> ! (Il m’a exploité ) '
         ]);
        DB::table('postags')->where('name','ADP')
                ->update([
            'full_name' => 'Préposition',
            'description' => '-Vu Glodderdal bis Denzlinge verlauft au die Badisch Wistross an dr Glodder <b>entlang</b>.<br>
-<b>Noh</b> ebbena 20 Johr Büechdruckarèi ìsch Mentelin àm 12. Dezamber 1478 z\'Stroßburri gstorwa.<br>
-Ere Tielekt werd as Walsertütsch bizaichnet, wo <b>zum</b> grösste Tail zum Höchstalemannische und zum chliinere Tail <b>zum</b>  Hochalemannische ghört.<br>
-Im Winter fliege d trockne Bletter durch d’ Luft <b>herum</b>. <br> -Ìm Gsàmta hàt\'r <b>ungfahr</b> 40 Biacher unter Duck gmàcht.<br>
'
         ]);
        DB::table('postags')->where('name','AUX')
                ->update([
            'full_name' => 'Auxiliaire',
            'description' => 'La catégorie regroupe les verbes hànn / hàn (avoir), sìnn / sín / sìì / sii (être), wère / waere / werre / war(d)e / wùrre / wurra (devenir), tüen / duen / düe : <br>
-Sallamols <b>ìsch</b> nur z\' Mainz druckt <b>worra</b>. <br><br>
<u>ATTENTION</u> : ils peuvent prendre l’étiquette VERB lorsqu’ils ont un sens lexical plein : <br>
S Gschaft vum Johannes Mentelin <b>hàt</b> schnall Erfolg <b>bikumma (VERB)</b>, ar <b>ìsch</b> a riicher Mànn <b>worra (VERB)</b>. <br>
Charles , wenn du wüescht , wie ich dich gern <b>hab (VERB)</b> ! '
         ]);
        DB::table('postags')->where('name','CONJ')
                ->update([
            'full_name' => 'Conjonction',
            'description' =>  'Les conjonctions de coordination (Awer, denn, oder, un…) :<br>
-<b>Àwer</b>  Johannes Mentelin hàt wohrschins scho zìmlig friajher fànga-n-à drucka, sogàr scho ànna 1458. <br>
-Si wird i verschidene Kantön <b>als</b>  Iiwohnergmeind bezeichnet. <br>
-Cas <u> Als </u> : <br>
&nbsp;&nbsp;&nbsp;&nbsp;-<b>Àls</b> Berüef ìsch \'r zeerscht „ Guldschriiwer “ ( Kalligraph un Büechschriiwer ) gsìì un hàt noochhar <b>àls</b> bìschäfliger Notàr gschàft.'
         ]);
        DB::table('postags')->where('name','DET')
                ->update([
            'full_name' => 'Déterminant',
            'description' => '-Du, Auguste, hierotsch <b>d\'</b> mademoiselle Riemer.<br>
-Si ältschta bekànnta Druckwark ìsch <b>a</b> làtiinischa Bibel ìn 49 Ziila („B49“), <b>dr</b> erscht Bànd ìsch vum Johr 1460.<br>
-<b>zèll</b> Kìnd ìsch krànk<br>
-ich hàbb <b>zèller</b> Mann gsèhn <br>
-er hét <b>kénn</b> Kìnder<br> 
-sie hànn <b>vìel</b> Kìnder<br>
-Es ìsch <b>miner</b> Huet<br> 
-Es ìsch <b>din</b> Buech<br> 
-Der Krämer, <b>dessen</b>  Ware gepfändet wurde, ist ...<br>
-<b>Welschin</b> isch dä Huät?<br>'
         ]);
        DB::table('postags')->where('name','NUM')
                ->update([
            'full_name' => 'Nombre',
            'description' => '-<b>dréj</b> Uehr<br>
-àm <b>zehne</b> <br>
-e Vìertel ìwer <b>zwei</b><br>
-Ìm Gsàmta hàt\'r ungfahr <b>40</b>  Biacher unter Duck gmàcht.'
         ]);
        DB::table('postags')->where('name','PRON')
                ->update([
            'full_name' => 'Pronom',
            'description' => '-<b>Das</b> isch nit nume für d Bostauti eso gsi, sondern au für anderi<br> konzessionierti Buslinie und au für d Iisebahn <b>Das</b>  isch d Andromeda-Galaxie<br>
-er hét <b>kénni</b><br>
-sie hànn <b>vìel</b> <br>
-<b>Ma</b> weiß nìt gnàui, wo un wenn àss er d Technik vum Büechdrucka glehrt hàt.<br>
-Es ìsch miner Huet (c’est mon chapeau) Es ìsch <b>miner</b> (c’est le mien)<br>
-Es ìsch din Buech (C’est ton livre) Es ìsch <b>dins</b> (c’est le tien)
-D’r Mànn, <b>wo</b> gross ìsch … <br>
-Republik isch ä Staatsform, <b>wo</b> sech aus Gägemodäu zur Monarchii und zur Despotii gseht.<br>
-Er wäscht <b>sich</b> d’Händ <br>
-Sie kaufe <b>sich</b> e nejs Auto<br>
-Ar fragt <b>wer</b>  kommt <br>
-Ja, <b>was</b>  isch do ze mache, nüsstelle kann.<br>
-Sina Kenntnissa hàt\'r àlso känna lehra, antwader direkt z\'Mainz oder dur <b>ebber</b> wo-n-ìhm dàs zeigt hàt, vìllìcht dr Heinrich Eggestein.<br>'
         ]);
        DB::table('postags')->where('name','PART')
                ->update([
            'full_name' => 'Particule',
            'description' => '-D Germanischt Wolfgang Kleiber het feschtgstellt, ass s Alemannisch „sowohl lexikographisch als auch dialektgeographisch als das <b>am</b> besten erforschte Sprachareal innerhalb der „Teutonia“ ka gälte.<br>
<b>Ja</b> papa, er isch noch do.
-Ma weiß <b>nìt</b> gnàui, wo un wenn àss er d Technik vum Büechdrucka glehrt hàt.<br>
-Her nùtzt  mich <b>üss</b> <br> 
-La particule &quot <u><b>zu</b></u> &quot avant un infinitif.'
         ]);
        DB::table('postags')->where('name','SCONJ')
                ->update([
            'full_name' => 'Conjonction de subordination',
            'description' => '-Ma weiß nìt gnàui, wo un wenn <b>àss</b> er d Technik vum Büechdrucka glehrt hàt. <br>
-<b>Wenn</b> dàs stìmmt, war àlso dr Johannes Mentelin, noch vor em Heinrich Eggestein, dr erscht Büechdrucker vu Stroßburri gsìì.'
         ]);
        DB::table('postags')->where('name','PUNCT')
                ->update([
            'full_name' => 'Ponctuation'
         ]);
        DB::table('postags')->where('name','SYM')
                ->update([
            'full_name' => 'Symbole',
            'description' => '<b>*</b>  um 1410 z\'Schlettstàdt; <b>†</b>  12. Dezamber 1478 z\'Stroßburri'
         ]);
        DB::table('postags')->where('name','X')
                ->update([
            'full_name' => 'Mot étranger',
            'description' => 'Eh <b>bien</b>  , ich will sehn , wer Herr im Hüs isch , ich odder Ihr !'
         ]);
    }
}
