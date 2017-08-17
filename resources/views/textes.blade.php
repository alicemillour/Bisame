@extends('layouts.app')
@section('style')
<link target="_blank" href="{{ asset('css/game.css') }}" rel="stylesheet" type="text/css" >
@endsection
@section('script')
<!--<script type="text/javascript" src="{{ asset('js/game.js') }}"></script>-->
<script type="text/javascript" src="{{ asset('js/game.js') }}">
</script>
@endsection
@section('content')

@include('partials.nav')
<div class="main">
    <div class="main-container">
        <h3> Vous trouverez sur cette page les liens vers les différents textes utilisés </h3>
        <br>
        <div class="fancy-border " >
            <button class="accordion" > <i class="fa fa-wikipedia-w" aria-hidden="true"></i> Pages Wikipédia </button>
            <div style="" class="panel semi-transparent ">
                <ul>
                    <li><a style="color: black" target="_blank" href="https://als.wikipedia.org/wiki/Els%C3%A4ssisches_Museum_(Stra%C3%9Fburg)"> Elsassisch Museum (Stroßburri) </a> </li>
                    <br>
                    <li><a style="color: black" target="_blank" href="https://als.wikipedia.org/wiki/Johannes_Mentelin"> Johannes Mentelin </a> </li>
                    <br>
                    <li><a style="color: black" target="_blank" href="https://als.wikipedia.org/wiki/Orthal"> Orthal </a> </li>
                    
                </ul>
                
            </div>
            <div class="semi-transparent"> <br> </div>
            <button class="accordion" > <i class="fa fa-cutlery" aria-hidden="true"></i> Recettes de cuisine </button>
            <div class="panel semi-transparent">
                <ul>
                    <li><a style="color: black" target="_blank" href="http://www.olcalsace.org/sites/default/files/publications/recette_saumon_lentilles.pdf"> Dos de saumon lardé aux lentilles vertes et crème de raifort  </a> </li>
                    <br>
                    <li><a style="color: black" target="_blank" href="http://www.olcalsace.org/sites/default/files/publications/recette_flan_asperges.pdf"> Flan aux asperges </a> </li>
                    <br>
                    <li><a style="color: black" target="_blank" href="http://www.olcalsace.org/sites/default/files/publications/recette_sabayon.pdf"> Fraises et rhubarbe au sabayon </a> </li>
                    
                </ul>
            </div>
            <div class="semi-transparent"> <br> </div>
            
            <button class="accordion" > <i class="fa fa-book" aria-hidden="true"></i> Œuvres littéraires </button>
            <div class="panel semi-transparent">
                <ul>
                    <li><button class="accordion accordion-second" > <i> D'r Hoflieferant </i> - G. STOSKOPF  - 1906, p. 53  </button> 
                        <div style="white-space: pre-wrap;" class="panel semi-transparent ">
                            [ ... ]
                            Brüchsch kenn Angscht ze han for mich , papa .
                            Ich hab eini im Au , wie sowohl vum wisseschaftliche , als au vum praktische unn vum menschliche Standpunkt üs mine-n- Anforderunge entschpricht . 
                            Unn ich hab hytt de-n- Entschluss gfasst , nur die Frau ze hierothe , wie mir passt . 
                            Bravo , Auguste , ganz vun minere Meinung ! Dini Aprobation brücht 'r allewäj ! 
                            Ich mach 's également eso . 
                            Bravo ! Alls besser ! 
                            Eh bien , ich garantier Ejch , dass Ihr mine Wille reschpektiere wäre ! 
                            Du , Auguste , hierotsch d' mademoiselle Riemer . Papa niemols ! Unn wenn du bis an de plafond springsch ! Fallt m'r nit in so hoch ze springe ! 
                            Geh e Gottsnamme im Deifel zue , no rennsch au kein Heiliger um ! Awwer , papa ! Toi , tais-toi ! Unn du hierothsch de Baron de Rose , wie am Sundaa uff Visit kummt . 
                            Niemols , Babbe ! Niemols ! So ? Eh bien , ich will sehn , wer Herr im Hüs isch , ich odder Ihr ! O , wie bin ich unglüecklich ! 
                            Charles , wenn du wüescht , wie ich dich gern hab ! Lisa ! Charles , ich hab dich gar nit erüs höre kumme . Du hesch doch nit ghört , was ich ewe do for mich gsaat hab ? 
                            [ ... ]
                            
                            <a style="color: black" target="_blank" href=" https://archive.org/details/drhoflieferantel00stos"> <b> Lien vers la pièce </b> </a>
                        </div>
                    </li>
                    <br>
                    <li> 
                        <button class="accordion accordion-second" >﻿KIND HASCH GEDULD - gK</button>
                        <div style="white-space: pre-wrap; text-align: center" class="panel semi-transparent ">
                            <ul>@include('partials.gerard1')</ul>
                        </div>
                    </li>
                    <br>
                    <li> 
                        <button class="accordion accordion-second" >﻿<i> E Hochzit in de 50er Johre </i> - Raymond Weissenburger</button>
                         
                        <div style="white-space: pre-wrap" class="panel semi-transparent ">                           
                            <ul>@include('partials.raymond')</ul>
                        </div>
                       
                    </li>
                </ul>
            </div>
            <div class="semi-transparent"> <br> </div>
        </div>
        <br>
    </div>
    
    <div class="main-footer">
        
    </div>
</div>
@endsection
