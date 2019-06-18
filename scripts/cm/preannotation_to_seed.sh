#!/bin/sh

echo "début du script";
echo "$2\n";

# $1 : scripts directory
# $2 : preannotated file path
# $3 : corpora directory
# $4 : corpus name

    filename=$(basename "$2" .txt.tok)
    echo "corpus_name;sentence_position;word_position;value;postag_name;confidence_score;tagger" > "$3"/preannotation/preannotation-1/recipes/$filename.preannotation_seed 
    # escape slash
cp "$3"/preannotation/preannotation-1/recipes/"$filename".preannotated "$3"/preannotation/preannotation-1/recipes/"$filename".preannotated2
    sed -i 's/\/\/PUNCT/_SLASH_\/PUNCT/g' "$3"/preannotation/preannotation-1/recipes/"$filename".preannotated
    sed -i 's/\([0-9]\)\/\([0-9]\)/\1_SLASH_\2/g' "$3"/preannotation/preannotation-1/recipes/"$filename".preannotated
    line_nb=1;
    word_nb=1;    
    while read -r line;
    do
        echo "reading line"
        word_nb=1;
        for word in $line
        do
            real_word=$(echo $word | cut -d '/' -f1)
            tag=$(echo $word | cut -d '/' -f2)
            echo "$4";
            echo "$4;$line_nb;$word_nb;$real_word;$tag;10;MElt">> "$3"/preannotation/preannotation-1/recipes/$filename.preannotation_seed 
            word_nb=$((word_nb + 1));
        done
        line_nb=$((line_nb + 1));
    done < "$3"/preannotation/preannotation-1/recipes/"$filename".preannotated

    # unescape * and escape ;
    sed -e 's/;;;/;\";\";/g' "$3"/preannotation/preannotation-1/recipes/$filename.preannotation_seed  > tmp.txt ; 
    sed -i 's/\\\*/*/g' tmp.txt ; 
    cp tmp.txt "$3"/preannotation/preannotation-1/recipes/$filename.preannotation_seed
    # unescape slash    
    sed -i 's/_SLASH_/\//g' "$3"/preannotation/preannotation-1/recipes/$filename.preannotation_seed
    cut -d';' -f5 "$3"/preannotation/preannotation-1/recipes/$filename.preannotation_seed   > "$3"/preannotation/preannotation-1/recipes/$filename.MEltTags