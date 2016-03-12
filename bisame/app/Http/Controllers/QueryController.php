<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Editeur;
class QueryController extends Controller
{


    public function index()
    {

    $editeurs = DB::table('editeurs')->get();
    foreach ($editeurs as $editeur) {
    echo $editeur->nom, '<br>';
}
        return view('query');
    }
}