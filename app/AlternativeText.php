<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlternativeText extends Model
{
	protected $fillable = [
		'user_id',
		'translatable_id',
		'translatable_attribute',
		'translatable_type',
		'value',
		'offset_start',
		'offset_end',
	];
	
    /**
     * Get all of the owning translatable models.
     */
    public function translatable()
    {
        return $this->morphTo();
    }

    /**
    * Return the alternative text's author
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }    

}
