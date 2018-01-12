#!/bin/sh

echo "début du script";
echo "$2\n";

# $1 : scripts directory
# $2 : raw file path
# $3 : corpora directory
# $4 : corpus name

filename=$(basename "$2" .txt.tok)

> "$3"/preannotation/TreeTagger/recipes/$filename.treetag_pre-annotation_seed

file="$3"/preannotation/TreeTagger/recipes/$filename.words.german

    echo " ************ $file"
    filename=$(basename "$file" .words.german)
    sed -i 's/""/"/g' "$3"/preannotation/TreeTagger/recipes/$filename.words.german
    # replacing * with \*
    cat $file;
    sed 's/\*/\\*/g' "$file" > "$3"/preannotation/TreeTagger/recipes/"$filename".tmp
    "$1"/tree-tagger-german "$3"/preannotation/TreeTagger/recipes/"$filename".tmp > "$3"/preannotation/TreeTagger/recipes/$filename.tagged
    #rm $filename.tmp
    sed -i 's/;/POINT_VIRGULE/g' "$3"/preannotation/TreeTagger/recipes/$filename.tagged 
    sed -i 's/\t/;/g'  "$3"/preannotation/TreeTagger/recipes/$filename.tagged 
    ## switch to universal pos tagset
    while read -r line; do  
        cmd="$line "$3"/preannotation/TreeTagger/recipes/$filename.tagged"
        if ! eval $cmd ; then
            echo $cmd
        fi
        eval $cmd
    done < $1/TreeTagsetToUnivTagset.txt   
    cut -d';' -f2 "$3"/preannotation/TreeTagger/recipes/$filename.tagged > "$3"/preannotation/TreeTagger/recipes/$filename.TTtags    
    #echo "corpus_name;sentence_position;word_position;value;postag_name;confidence_score;tagger" > "$3"/preannotation/TreeTagger/recipes/$filename.treetag_pre-annotation_seed
    paste -d ";" "$3"/word_seed/recipes/$filename.word_seed "$3"/preannotation/TreeTagger/recipes/$filename.TTtags >> "$3"/preannotation/TreeTagger/recipes/$filename.treetag_pre-annotation_seed
    sed -i 's/POINT_VIRGULE/";"/g' "$3"/preannotation/TreeTagger/recipes/$filename.treetag_pre-annotation_seed
    nb_pretag=$(cat "$3"/preannotation/TreeTagger/recipes/$filename.treetag_pre-annotation_seed | wc -l)
    nb_wordseed=$(cat "$3"/word_seed/recipes/$filename.word_seed | wc -l)

    sed -i 's/$/;10;TreeTagger/g' "$3"/preannotation/TreeTagger/recipes/$filename.treetag_pre-annotation_seed

    # vérification qu'il n'y a pas eu d'erreur au moment où on recolle annotations et words.
    if [ $nb_pretag -ne $nb_wordseed ];
    then
        echo "$filename : error"
    fi

