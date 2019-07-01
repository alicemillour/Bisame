#!/bin/sh

echo "début du script";
echo "$2\n";

# $1 : scripts directory
# $2 : raw file path
# $3 : corpora directory
# export PATH=$PATH:'/Library/Frameworks/Python.framework/Versions/3.5/bin/';

filename=$(basename "$2" .txt)

python3 "$1/py_tokeniser.py" -f csv mfe utf-8 $2


# Points virgule (temporaire)
# sed -i   's/;/POINT_VIRGULE/g' $2.tok
# suppression lignes vides
sed -i   '/^\s*$/d' $2.tok
# échappement astérisques
sed -i   's/\*/\\*/g' $2.tok
# échappement guillemets
sed -i   's/\"/\"\"/g' $2.tok

## déplacement des fichiers dans le répertoire /tokenized

mkdir -p $tokenized/$corpus
cp "$2".tok "$3"/tokenized/recipes/
