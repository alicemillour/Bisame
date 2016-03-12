<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{

    public function auteurs()
    {
        return $this->belongsToMany('App\Models\Auteur');
    }

    public function editeur()
    {
        return $this->belongsTo('App\Models\Editeur');
    }

}