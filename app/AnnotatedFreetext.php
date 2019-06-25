<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnnotatedFreetext extends Model
{
    protected $fillable = ['freetext_id','user_id'];

    public function annotator()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

}
