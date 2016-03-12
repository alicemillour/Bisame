<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function posts()
    {
        return $this->hasMany('App\Models\Annotation');
    }
}
