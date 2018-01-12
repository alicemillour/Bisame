#!/bin/sh

echo "début du script";
echo "$2\n";

# $1 : scripts directory
# $2 : raw file path
# $3 : corpora directory
export PATH=$PATH:'/Library/Frameworks/Python.framework/Versions/3.5/bin/';

filename=$(basename "$2" .txt)

python3 "$1/py_tokeniser.py" -f csv gsw utf-8 $2


# recoller les M’r et m’r (guillemet particulier)
sed -i '' -e 's/\(^[M|m]\| [m|M]\) ’r/\1’r /g' $2.tok
sed -i '' -e "s/\(^[M|m]\| [m|M]\) 'r/\1'r /g" $2.tok
# recoller les  ’s et  ‘s  (guillemets particuliers)    
sed -i '' -e 's/ ’ s / ’s /g' $2.tok
sed -i '' -e 's/^’ s /’s /g' $2.tok
sed -i '' -e 's/ ‘ s / ‘s /g' $2.tok
sed -i '' -e 's/^‘ s /‘s /g' $2.tok
# suppression des balises
sed -i '' -e 's/<\([a-zA-Z /]*\)>//g' $2.tok
# Points virgule (temporaire)
# sed -i '' -e 's/;/POINT_VIRGULE/g' $2.tok
# suppression lignes vides
sed -i '' -e '/^\s*$/d' $2.tok
# échappement astérisques
sed -i '' -e 's/\*/\\*/g' $2.tok
# échappement guillemets
sed -i '' -e 's/\"/\"\"/g' $2.tok

## déplacement des fichiers dans le répertoire /tokenized

mkdir -p $tokenized/$corpus
cp "$2".tok "$3"/tokenized/recipes/
