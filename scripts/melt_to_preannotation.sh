#!/bin/sh

echo "début du script";
echo "$2\n";

# $1 : scripts directory
# $2 : melt_tagged file path
# $3 : corpora directory

    filename=$(basename "$2" .txt.tok)
    rm "$3"/preannotation/MElt/recipes/$filename.melt_pre-annotation_seed 
    # escape slash
    sed -i 's/\/\/PUNCT/_SLASH_\/PUNCT/g' "$3"/preannotation/MElt/recipes/"$filename".melt_tagged
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
            echo "$filename;$line_nb;$word_nb;$real_word;$tag;10;MElt">> "$3"/preannotation/MElt/recipes/$filename.melt_pre-annotation_seed 
            word_nb=$((word_nb + 1));
        done
        line_nb=$((line_nb + 1));
    done < "$3"/preannotation/MElt/recipes/"$filename".melt_tagged

    # unescape * and escape ;
    sed -e 's/\\\*/*/g' -e 's/;;;/;\";\";/g' "$3"/preannotation/MElt/recipes/$filename.melt_pre-annotation_seed  > tmp.txt ; 
    cp tmp.txt "$3"/preannotation/MElt/recipes/$filename.melt_pre-annotation_seed
    # unescape slash    
    sed -i 's/_SLASH_/\//g' "$3"/preannotation/MElt/recipes/$filename.melt_pre-annotation_seed
    cut -d';' -f5 "$3"/preannotation/MElt/recipes/$filename.melt_pre-annotation_seed   > "$3"/preannotation/MElt/recipes/$filename.MEltTags

