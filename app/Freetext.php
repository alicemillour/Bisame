<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;
use App\Traits\Commentable;
use App\Traits\Mediable;
use App\Traits\Likeable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Freetext extends Model
{
    use Translatable, Commentable, Mediable, Likeable, SoftDeletes;

    protected $dates = ['deleted_at'];
    
	protected $fillable = [
		'title',
		'content',
		'corpus_language_id',
		'category_id',
		'commentary',
		'user_id'
	];

    /**
    * Return the freetexts's author
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    /**
    * Return the freetexts's ingredients
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

    /**
    * Return the freetexts's anecdotes
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function anecdotes()
    {
        return $this->hasMany(Anecdote::class);
    }

    /**
    * Return the freetexts's contributors
    *
    * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
    */
    public function contributors()
    {
    	return $this->belongsToMany('App\User', 'alternative_texts', 'translatable_id', 'user_id')
    				->where('translatable_type','App\Freetext')->distinct();
    }


    /**
     * Scope a query to only include freetexts to annotate.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToAnnotate($query)
    {
        return $query->where('annotated', '=', 0);
    }

    /**
     * Scope a query to only include freetexts to annotate.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToValidate($query)
    {
        return $query->where('annotated', '>', 0);
    }
}
