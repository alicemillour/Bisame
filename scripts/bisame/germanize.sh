#!/bin/sh

echo "début du script";
echo "$2\n";

# $1 : scripts directory
# $2 : raw file path
# $3 : corpora directory
filename=$(basename "$2" .txt.tok)

rm -f $3/germanized/recipes/$filename.german

cp "$3"/word_seed/recipes/$filename.word_seed "$3"/preannotation/TreeTagger/recipes/$filename.word_seed.german
sed -i   "s/;;/;POINT_VIRGULE/g" "$3"/preannotation/TreeTagger/recipes/$filename.word_seed.german

cut -d';' -f4 "$3"/preannotation/TreeTagger/recipes/$filename.word_seed.german > "$3"/preannotation/TreeTagger/recipes/$filename.words.german
while read -r line; do  
    cmd="$line $3/preannotation/TreeTagger/recipes/$filename.words.german"
    if ! eval $cmd ; then
        echo $cmd
    fi
    eval $cmd
done < $1/gsw-to-german.txt    
sed -i   "s/'\|\`\([a-z]*\)/\1/g" "$3"/preannotation/TreeTagger/recipes/$filename.words.german 
sed -i   "s/’\([a-z]*\)/\1/g" "$3"/preannotation/TreeTagger/recipes/$filename.words.german 
sed -i   "s/\([a-z]*\)'\|\`/\1/g" "$3"/preannotation/TreeTagger/recipes/$filename.words.german
sed -i   "s/\([a-z]*\)’/\1/g" "$3"/preannotation/TreeTagger/recipes/$filename.words.german
sed -i   's/\([0-9]\)\./\1 /g' "$3"/preannotation/TreeTagger/recipes/$filename.words.german
sed -i   's/\([0-9]\).\([0-9]\)/\1\2/g' "$3"/preannotation/TreeTagger/recipes/$filename.words.german
sed -i   's/\([0-9]\),\([0-9]\)/\1\2/g' "$3"/preannotation/TreeTagger/recipes/$filename.words.german
sed -i   "s/\([a-z]*\)/\1/g" "$3"/preannotation/TreeTagger/recipes/$filename.words.german
