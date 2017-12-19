<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = ['quantity','name','recipe_id'];

    public function alternative_texts($attribute=null)
    {
    	if($attribute)
        	return $this->morphMany('App\AlternativeText', 'translatable')->where('translatable_attribute',$attribute);
    	else
    		return $this->morphMany('App\AlternativeText', 'translatable');
    }
    
}
