<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class Anecdote extends Model
{
	use Translatable;

    protected $fillable = [
        'user_id',
        'recipe_id',
        'content'
    ];

    /**
    * Return the anecdote's author
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

}
