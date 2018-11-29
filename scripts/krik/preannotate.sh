#!/bin/sh

echo "début du script";
echo "$2\n";
export PATH=$PATH:'/usr/local/bin/';
# $1 : scripts directory
# $2 : raw file path
# $3 : corpora directory

filename=$(basename "$2" .txt.tok)
# Modèle de MElt à modifier

mkdir -p "$3"preannotation/preannotation-1/recipes

cat "$3"/tokenized/recipes/$filename.txt.tok | MElt -l MElt_creole-guadeloupe_1500-tokens > "$3"/preannotation/preannotation-1/recipes/$filename.preannotated

sed -i "s/;_'s/;\/PUNCT 's/g" "$3"/preannotation/preannotation-1/recipes/$filename.preannotated
  