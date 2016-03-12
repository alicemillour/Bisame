<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Editeur extends Model
{

    public function livres()
    {
        return $this->hasMany('App\Models\Livre');
    }

}