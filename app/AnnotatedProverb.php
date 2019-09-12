<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnnotatedProverb extends Model
{
    protected $fillable = ['proverb_id','user_id'];

    public function annotator()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

}
