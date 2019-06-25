<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnnotatedPoem extends Model
{
    protected $fillable = ['poem_id','user_id'];

    public function annotator()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

}
