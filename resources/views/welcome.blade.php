@extends('layouts.app')
@section('style')
<link href="{{ asset('css/home.css') }}" rel="stylesheet" type="text/css" >
@endsection
@section('content')
<div class="container">
    <div class="title ostrich"> BISAME </div>
    <h3 class="info-message">
        <br> L'<b class="ostrich">alsacien</b> fait partie de la grande majorité des "langues peu dotées" au sens des technologies du langage.</br>  
        <br> Aucun des outils des nouvelles technologies de la langue - par exemple : correction orthographique, aide à la traduction, extraction d'information - qui contribuent à faire exister les langues sur Internet n'est développé pour l'alsacien.</br> 
        <br> La raison ? Il existe très peu de données "annotées", c'est-à-dire enrichies d'informations linguistiques, à partir desquelles développer de tels outils.
C'est pourquoi nous faisons appel à vous : locuteurs de l'alsacien, passionnés ou non de grammaire, désireux dans tous les cas de contribuer au déploiement de votre langue, participez grâce à <b><span class="ostrich"> BISAME</span> </b> à la création d'un corpus de l'alsacien annoté en catégories grammaticales !</br> 
        <br> Pour tout complément d'information sur ce projet de recherche réalisé dans le cadre d'un master en Traitement Automatique des Langues à la Sorbonne, me contacter par mail : alice.millour@abtela.eu. </br>
        <br> Alice </br>
    </h3>
</div>

@endsection
