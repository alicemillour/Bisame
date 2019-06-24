<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ValidatedRecipe extends Model
{
    protected $fillable = ['recipe_id','user_id'];

}
