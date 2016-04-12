<?php
$editeurs = DB::table('editeurs')->get();
foreach ($editeurs as $editeur) {
    echo $editeur->nom, '<br>';
}