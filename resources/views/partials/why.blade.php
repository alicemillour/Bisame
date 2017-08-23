<h3 class="question"> <b class="ostrich">BISAME</b> ? Wàs ìsch dàs ? </h3> <br>
<b class="ostrich">BISAME</b>  est un projet de recherche qui vise à recueillir des informations linguistiques sur des mots en alsacien. 
Nous invitons tout dialectophone, passioné (ou non !) de grammaire, à participer à ce projet collaboratif.
<br>
<br>
En pratique, il s'agit d'associer des catégories grammaticales à des mots alsaciens : 
<div class="media">
        <div class="media-body">
                <video width="800" height="400" controls>  
    <source src="{{ asset('video/annotation.mp4') }}" type="video/mp4">  
    <source src="{{URL::asset('video/annotation.ogv')}}" type="video/ogg">  
    Votre navigateur ne supporte pas les formats vidéo mp4 et ogv.
                </video>
<!--            <iframe width="900" height="500" src="{{ asset('video/annotation.mp4') }}" frameborder="0" allowfullscreen>
            </iframe>
             <source src="pr6.ogv" type="video/ogg; codecs=theora,vorbis" />
  <source src="pr6.mp4" />
        --></div>
    </div>
<br> <h3>Mais la grammaire, c'est loin... !</h3>
Pas de panique ! Une phase de formation permet de se remettre les idées au clair sur les 18 catégories possibles. De plus un aide mémoire sous forme d'exemples est à votre disposition.

<h3 class="question" > Wurum mìtmàcha ? - Pourquoi participer ? </h3>
<p align=left style="margin-left: 30px">
<ol align=left style="margin-left: 30px">
    <li> Les ressources linguistique en ligne sont rares et l'annotation manuelle par des linguistes est (très) coûteuse. </li>

    <li> Ces ressources sont nécessaires pour développer de nouveaux outils qui contribuent à faire exister les langues sur Internet (par exemple : outils d'aide à la traduction, d'extraction d'information, moteurs de recherche, outils pédagogiques etc.).</li>
    <li> Les résultats d'ores et déjà obtenus sont encourageants ! </li> 
</ol>   
</p>
<div style="text-align:left"> Aujourd'hui <b class="ostrich">BISAME</b> c'est :  </div> 
    
<h3> {{$registered}} inscrits </h3>
<h3> {{$trained_user}} participants ayant finalisé la phase d'entraînement </h3>
<h3> {{$participant}} participants ayant produit des annotations </h3>
<h3> {{$days_of_annotation}} jours d'annotation </h3>
                
<div style="text-align:left"> soit :</div>
               
<h3> {{$non_admin_annotations}} annotations produites </h3>
<h3> Un corpus de {{$total_distinct_words_annotated_not_ref}} mots distincts annotés collaborativement : <a href="{{ url('/download_txt/wikipedia-20160406-bisame.conll')  }}" target="_blank" style="font-size:0.7em"><b>Télécharger (CONLL)</b> </a> </h3>
               
<h3> Un outil d'annotation automatique entraîné grâce à cette nouvelle ressource : <a href="{{ url('/download_zip/melt-20160406-bisame.tar.gz')  }}" target="_blank" style="font-size:0.7em"><b>Télécharger&nbsp;le&nbsp;modèle&nbsp;(MElt)</b> </a> </h3>
                
        

Pour plus de détails, vous pouvez consulter la publication à laquelle ce projet a donné lieu :  <a href="https://alicemillour.github.io/assets/taln2017_alsacien.pdf" target="_blank" ><b> Article </b> </a>
           

<h3 class="question" >  Ìch mecht garn mìtmàcha... àwer wia màcht ma ? - Comment participer ? </h3>
Rien de plus simple, il suffit de choisir un pseudonyme et de créer un compte en cliquant sur le bouton <br> <b class="ostrich">INSCRIPTION</b>. <br>
Une fois la phase de formation complétée, vous pourrez commencer à annoter un des textes présents sur la plate-forme (en ce moment <i> E Hochzit in de 50er Johre </i> de <b> Raymond Weissenburger</b>, texte à retrouver dans son intégralité <a style="color:#AC1E44;" href="/textes" target="_blank"/> ici</a>)</h3>. 
<br>
