#!/bin/sh

echo "début du script";
echo "$2\n";

# $1 : scripts directory
# $2 : raw file path
# $3 : corpora directory
# $4 : real corpus name (recipe-id_corpus-name)


filename=$(basename "$2" .txt.tok)
echo "corpus_name;sentence_position;position;value" > "$3"/word_seed/recipes/$filename.word_seed
sed -e 's/;/";"/g' "$3"/tokenized/recipes/$filename.txt.tok
line_nb=1;
word_nb=1;  

mkdir -p "$3"/word_seed/recipes/

while read -r line;
do  
    word_nb=1;
    for word in $line
        do
            echo "$4;$line_nb;$word_nb;$word" >> "$3"/word_seed/recipes/$filename.word_seed
            word_nb=$((word_nb + 1));
        done    
    line_nb=$((line_nb + 1));
done < "$3"/tokenized/recipes/$filename.txt.tok
sed -e 's/";"/;/g' "$3"/tokenized/recipes/$filename.txt.tok

