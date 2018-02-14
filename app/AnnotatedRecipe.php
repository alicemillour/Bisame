<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnnotatedRecipe extends Model
{
    protected $fillable = ['recipe_id','user_id'];

}
