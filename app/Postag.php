<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Postag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','category','full_name','difficulty','order','description'
    ];

    public function posts()
    {
        return $this->hasMany('App\Annotation');
    }
}
