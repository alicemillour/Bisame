<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auteur extends Model
{

    public function livres()
    {
        return $this->belongsToMany('App\Models\Livre');
    }

}