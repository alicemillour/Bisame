#!/bin/sh

echo "début du script";
echo "$2\n";

# $1 : scripts directory
# $2 : raw file path
# $3 : corpora directory
# export PATH=$PATH:'/Library/Frameworks/Python.framework/Versions/3.5/bin/';

filename=$(basename "$2" .txt)

python3 "$1/py_tokeniser.py" -f csv gcf utf-8 $2


# on raccroche tous les traits d'union
sed -i 's/- /-/g' $2.tok

# on raccroche certaines formes figées
# an_jénéral
sed -i 's/an jénéral/an_jénéral/g' $2.tok
# anmem_tan
sed -i 's/anmem tan/anmem_tan/g' $2.tok
# gwo_ka
sed -i 's/gwo ka/gwo_ka/g' $2.tok
# konyè_la
sed -i 's/konyè la/konyè_la/g' $2.tok
# men_si
sed -i 's/\bmen\b \bsi\b/men_si/g' $2.tok
# a-y
sed -i 's/\b\([a|A]\)\b \by\b/\1-y/g' $2.tok
# a_pa
sed -i 's/\b\([a|A]\)\b \bpa\b/\1_pa/g' $2.tok
# a_fos
sed -i 's/\b\([a|A]\)\b f\([ò|o]\)s/\1_f\2s/g' $2.tok
# ki_moun ki_jan ki_lè etc.
sed -i "s/\b\(ki\|pon\) \(jan\|lè\|moun\|koté\)/\1_\2/g" $2.tok
# nimpot_ki
sed -i 's/\([n|N]\)impot ki/\1impot_ki/g' $2.tok
# on_lo
sed -i 's/\b\(\b[o|O]n\b\)\b \blo\b/\1_lo/g' $2.tok 
# an mwen tan mwen  # an nou tan nou
sed -i 's/\b\([t]*\)an \(mwen\|nou\)\b/\1an_\2/g'  $2.tok 

# a 'w t 'w
sed -i "s/\b\([a|t]\) 'w\b/\1_'w/g"  $2.tok

# a li ta li / a zòt ta zòt / a yo ta yo
sed -i 's/\b\(a\|ta\)\b \b\(li\|z[ò|o]t\|yo\)\b/\1_\2/g'  $2.tok 

# on raccroche les 'w 'y -y ’ay etc dans les cas de saX ou baX
sed -i "s/\b\(sa\|a\|ba\)\b \('w\|-y\|'y\)\b/\1\2/g" $2.tok

# Remove empty lines
sed -i '/^$/d'  $2.tok


## déplacement des fichiers dans le répertoire /tokenized

mkdir -p $tokenized/$corpus
cp "$2".tok "$3"/tokenized/recipes/
