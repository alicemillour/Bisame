<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annotation extends Model
{
    protected $table = 'annotations';

    protected $fillable = ['word_id','postag_id','user_id','confidence_score'];

    public function postag()
    {
        return $this->belongsTo('App\Postag');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function word()
    {
        return $this->belongsTo('App\Word');
    }
}
