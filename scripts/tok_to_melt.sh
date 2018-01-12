#!/bin/sh

echo "début du script";
echo "$2\n";
export PATH=$PATH:'/usr/local/bin/';
# $1 : scripts directory
# $2 : raw file path
# $3 : corpora directory

filename=$(basename "$2" .txt.tok)
# Modèle de MElt à modifier
cat "$3"/tokenized/recipes/$filename.txt.tok | MElt -l alsacien_Lmo-0126-300-9-sentences > "$3"/preannotation/MElt/recipes/$filename.melt_tagged

