
## Installation :
```
$ git clone https://github.com/alicemillour/Bisame.git
$ cd Bisame
$ cp .env.example .env
$ composer install
$ composer update
$ php artisan key:generate
```
Éditez .env et remplacez les attributs de la base de données avec les vôtres.

Remarque : en production au lieu de `composer install`, `composer install --no-dev`

## Avant de commencer

Vous devez publier les assets de laravel-filemanager :
```
php artisan vendor:publish --tag=lfm_public
```

Vous devez lancer la migration pour créer les tables de la base de données :
```
$ php artisan migrate
```

Seed de la base de données :
```
$ php artisan db:seed
```

Cela crée un utilisateur avec lequel vous pourrez vous connecter :
```
Email : admin@admin.com
Password : 4dm1n
```

Enfin, compilez les assets :
```
$ npm install
$ npm run dev
```

Génération de fake data :
```
$ php artisan db:seed --class=DevDatabaseSeeder
```

Pour faire un rollback complet de la base de données :
```
$ php artisan migrate:refresh --seed
```

Installation de Dusk (Browser Tests) :
```
$ php artisan dusk:install
```
Ajout user Admin (changer le *password* dans l'interface après connexion)
```
$ php artisan db:seed --class=UserTableSeeder
```
Import avatars, corpus d'entraînement et translations 
```
$ php artisan avatars:import    
$ php artisan corpus:import 
$ php artisan translations:import                  
```

-------------------------------------------------------------------------------------------------
# Adaptation de Recettes de Grammaire à une nouvelle langue 

## Adaptation de la partie Recettes + variantes (sans les annotations)

Ce guide est destiné à lister les différentes modifications à apporter au code source de Recettes de Grammaire pour créer une instance pour une nouvelle langue.

La valeur de la variable 'locale' (config/app.php) détermine quelle version de l'application est affichée.
Pour l'alsacien, 'locale' : 'bisame'
Pour le créole guadeloupéen, 'locale' : 'krik'
Elle est utilisée ailleurs pour récupérer les éléments propres à cette application. Le guide ci-dessous s'applique dans le cas où la variable 'locale' vaut 'new_language'. 

Pour créer une instance avec une nouvelle langue, il suffit de remplacer la valeur de la variable locale, ainsi que de créer les éléments détaillés ci-dessous.

### Éléments de design
Les éléments de design propres à une instance données sont : (attention aux extensions)

 - l'image de fond : `public/images/back-recipes-new_language.jpg`. En fonction de l'image de fond, il peut être utile d'adapter la valeur de transparence du bandeau supérieur dans `public/css/new_language.css`.
 - le favicon visible sur l'onglet du site web : `public/images/favicon-new_language.png`
 - l'image d'aperçu apparaissant lorsque l'URL est transmis par certains canaux `public/images/ppic-new_language.png`.

### Textes et wording 

 - Les fichiers `resources/views/partials/new_language-intro.php` (explication du projet qui s'affiche pages /register et  /info) et `resources/views/partials/new_language-charte.php` (charte affichée page /register) sont à adapter à vos langue et projet.
Les logos visibles en pied de page peuvent être modifiés dans le fichier `resources/views/partials/footer.php`.
 - Les différentes versions des textes affichés sur le site sont modifiables dans les fichiers du  répertoire /resources/lang/new_language/.
Voir en particulier home.php 'app-name', 'langue' etc. 

### Éléments spécifiques

#### langues 
Les participants peuvent renseigner les langues qu'ils parlent dans leur profil. Celles-ci sont enregistrées dans la base de données au moyen du fichier 
`database/seeds/LanguagesTableSeeder.php`.
Pour *seeder* les langues en bases, exécuter :
`$ php artisan db:seed --class=LanguagesTableSeeder`



## Adaptation de la partie  Annotation

Pour activer/désactiver les fonctionnalités liées à l'annotation des recettes, commenter/décommenter les parties de codes contenues dans les balises 
/* Fonctionnalité d'annotation */, dans les fichiers :

 - `app/Http/Controllers/RecipeController.php`
 - `resources/views/welcome.blade.php`
 - `resources/views/recipes/show.blade.php` 
 - `resources/views/recipes/_show-*.blade.php` 
 - `resources/views/partials/nav.blade.php`
 - `resources/views/layouts/app.blade.php`

### Tagset
Pour entrer le *tagset* en base de données, il faut
1.  créer un fichier de *seed* `database/seeds/csvs/new_language/postags.csv` au format suivant :
>     name;full_name;description
>     PROPN;Nom propre;"Les noms propres ne sont pas des noms communs."
>     NOUN;Nom commun;"Les noms communs ne sont pas des noms propres. Ex: ..."
>     etc.
Remarques : 
- Les descriptions correspondent au guide d'annotation qui sera présenté aux participants, dans nos versions nous donnons une liste d'exemples correspondant à la catégorie ainsi qu'éventuellement des consignes additionnelles (balises `<u>ATTENTION</u> ne pas confondre avec... etc.`)
- Les descriptions sont en HTML ce qui permet de leur ajouter des éléments de style.

2. Exécuter
`$ php artisan db:seed --class=PostagTableSeeder`
(voir le fichier `database/seeds/PostagTableSeeders.php` au besoin.)


### Scripts de prétraitements 

Les corpus ajoutés au moyen de la plateforme ainsi que les versions préannotées sont stockées dans le dossier `storage/app/new_language`. Veillez à accorder les bonnes autorisations d'écriture dans ce dossier.

Avant de pouvoir être annotées, les recettes saisies sont soumises à un certain nombre de prétraitements effectués par des scripts situés dans le dossier `scripts/new_language/`

Tous les appels aux scripts sont réalisés dans le fichier `app/Http/Controllers/RecipeController.php` et peuvent y être modifés au besoin. Les scripts de prétraitements utilisés par notre version sont :

 1. **Tokénisation** : `scripts/new_language/tokenize.sh`
     Entrée : $file.txt (dossier : `storage/app/new_language/corpus/raw/`)
     Sortie : $file.txt.tok (dossier : `storage/app/new_language/corpus/tokenized/`)
	exemple de sortie : recettes.txt.tok
> `D' grìene Lìnse 12 Stùnde làng inweiche lon .`


 2. **Transformation en "*seed*"** pour populer la base de données avec le corpus brut : `scripts/new_language/word_to_seed.sh`
     Entrée : $file.txt.tok (dossier : `storage/app/new_language/corpus/tokenized/`)
     Sortie : $file.txt.word_seed (dossier : `storage/app/new_language/corpus/word_seed/`)
     exemple de sortie : recettes.txt.word_seed 

>     corpus_name;sentence_position;position;value
>     recettes;1;1;D'
>     recettes;1;2;grìene
>     recettes;1;3;Lìnse
>     recettes;1;4;12
>     recettes;1;5;Stùnde
>     recettes;1;6;làng
>     recettes;1;7;inweiche
>     recettes;1;8;lon
>     recettes;1;9;.
 
     
 3. **Préannotation**  (réalisée dans notre cas avec MElt entraîné pour la langue considérée) `scripts/new_language/preannotate.sh`
	Entrée : $file.txt.tok (dossier : `storage/app/new_language/corpus/tokenized/`)
	Sortie : $file.txt.preannotated  (dossier : `storage/app/new_language/corpus/preannotation/preannotation-1/`)
     exemple de sortie : recettes.txt.preannotated
> `D'/DET grìene/ADJ Lìnse/NOUN 12/NUM Stùnde/NOUN làng/ADV inweiche/VERB lon/VERB ./PUNCT`
 4. **Transformation en "*seed*"** pour populer la base de données avec le corpus pré-annoté :`scripts/new_language/preannotation_to_seed.sh`
(transforme le format brown en format *seed*, le score de confiance `confidence_score` étant fixé arbitrairement à 10) 
	Entrée : $file.txt.preannotated
	Sortie : $file.txt.preannotation_seed
    exemple de sortie : recettes.txt.preannotation_seed
	
>     corpus_name;sentence_position;word_position;value;postag_name;confidence_score;tagger
>     recettes;1;1;D';DET;10;MElt  
>     recettes;1;2;grìene;ADJ;10;MElt 
>     recettes;1;3;Lìnse;NOUN;10;MElt  
>     recettes;1;4;12;NUM;10;MElt 
>     recettes;1;5;Stùnde;NOUN;10;MElt  
>     recettes;1;6;làng;ADV;10;MElt 
>     recettes;1;7;inweiche;VERB;10;MElt 
>     recettes;1;8;lon;VERB;10;MElt 
>     recettes;1;9;.;PUNCT;10;MElt

### Ressources à fournir pour la formation

Il est possible de configurer une formation obligatoire pour certaines parties du discours à annoter, dans ce cas, il faut fournir pour chaque étiquette `TAG` un corpus de formation `corpus_TAG` tel qu'il existe des occurrences de mots à étiqueter `TAG` et de mots pouvant être confondus avec des mots de catégorie `TAG`.

Exemple en français : 
Soit la tâche d'annotation en parties du discours avec le *tagset* suivant : `[ADJ;ADP;PUNCT;ADV;AUX;SYM;INTJ;CCONJ;X;NOUN;DET;PROPN;NUM;VERB
;PART;PRON;SCONJ`] 
et la phrase : "Franck et Théo sont donc partis.". 
La phrase doit être annotée "Franck/PROPN et/**CCONJ** Théo/PROPN sont/VERB donc/**ADV** partis/VERB ./PUNCT". Le mot *donc* est ambigu, car pourrait être annoté CCONJ dans un autre contexte. 
Considérant cet exemple, les fichiers à fournir pour l'entraînement de la catégorie CCONJ seraient les suivants :
1. `CCONJ_corpus.csv` 
Remarque : is_training = 1, is_active = 1
>     name;is_training;is_active
>     corpus_CCONJ;1;1
	
2. `CCONJ_words.csv`     
>     corpus_name;sentence_position;position;value
>     corpus_CCONJ;1;1;Franck
>     corpus_CCONJ;1;2;et
>     corpus_CCONJ;1;3;Théo
>     corpus_CCONJ;1;4;sont
>     corpus_CCONJ;1;5;donc
>     corpus_CCONJ;1;6;partis
>     corpus_CCONJ;1;7;.

3. `CCONJ_annotations.csv` 
Remarques : 
	- la valeur de confidence score n'est pas prise en compte
	- les annotations proposées au participant durant la phase de formation (`tagger` =  `training`) doivent être suivies par les annotations correctes attendues (`tagger` = `solution`). 
>     corpus_name;sentence_position;word_position;value;postag_name;confidence_score;tagger
>     corpus_CCONJ;1;1;Franck;10;PROPN;training
>     corpus_CCONJ;1;2;et;10;CCONJ;training
>     corpus_CCONJ;1;3;Théo;10;PROPN;training
>     corpus_CCONJ;1;4;sont;10;VERB;training
>     corpus_CCONJ;1;5;donc;10;CCONJ;training
>     corpus_CCONJ;1;6;partis;10;VERB;training
>     corpus_CCONJ;1;7;.;10;PUNCT;training
>     corpus_CCONJ;1;1;Franck;10;PROPN;solution
>     corpus_CCONJ;1;2;et;10;CCONJ;solution
>     corpus_CCONJ;1;3;Théo;10;PROPN;solution
>     corpus_CCONJ;1;4;sont;10;VERB;solution
>     corpus_CCONJ;1;5;donc;10;ADV;solution
>     corpus_CCONJ;1;6;partis;10;VERB;solution
>     corpus_CCONJ;1;7;.;10;PUNCT;solution

Une fois ces fichiers créés et placés dans le dossier  exécuter :
 `$ php artisan corpus:import CCONJ`
  (voir au besoin : `app/Console/Commands/ImportTrainingCorpus.php`).


