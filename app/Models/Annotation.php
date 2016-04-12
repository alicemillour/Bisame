<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annotation extends Model
{
    protected $table = 'annotations';

    protected $fillable = ['word_id','postag_id','user_id','confidence_score'];

    public function postag()
    {
        return $this->belongsTo('App\Models\Postag');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function word()
    {
        return $this->belongsTo('App\Models\Word');
    }
}
