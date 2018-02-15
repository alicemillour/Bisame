<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;
use App\Traits\Commentable;
use App\Traits\Mediable;
use App\Traits\Likeable;

class Recipe extends Model
{
	use Translatable, Commentable, Mediable, Likeable;

	protected $fillable = [
		'title',
		'content',
		'cooking_time_hour',
		'cooking_time_minute',
		'preparation_time_hour',
		'preparation_time_minute',
		'servings',
		'corpus_language_id',
		'commentary',
		'user_id'
	];

    /**
    * Return the recipe's author
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    /**
    * Return the recipe's ingredients
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

    /**
    * Return the recipe's anecdotes
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function anecdotes()
    {
        return $this->hasMany(Anecdote::class);
    }

    /**
    * Return the recipe's contributors
    *
    * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
    */
    public function contributors()
    {
    	return $this->belongsToMany('App\User', 'alternative_texts', 'translatable_id', 'user_id')
    				->where('translatable_type','App\Recipe')->distinct();
    }

	/**
	 * Get the recipe's total time.
	 *
	 * @return string
	 */
	public function getTotalTimeAttribute()
	{
		$total_time = \Carbon\Carbon::createFromTime(0,0,0,0);
		$total_time->addHours($this->cooking_time_hour);
		$total_time->addHours($this->preparation_time_hour);
		$total_time->addMinutes($this->cooking_time_minute);
		$total_time->addMinutes($this->preparation_time_minute);
		return $total_time->format('g \h i \m\i\n');
	}

	/**
	 * Get the recipe's cooking time.
	 *
	 * @return string
	 */
	public function getCookingTimeAttribute()
	{
	    return "{$this->cooking_time_hour} h {$this->cooking_time_minute} min";
	}

	/**
	 * Get the recipe's preparation time.
	 *
	 * @return string
	 */
	public function getPreparationTimeAttribute()
	{
	    return "{$this->preparation_time_hour} h {$this->preparation_time_minute} min";
	}

	/**
	 * Get the recipe's preparation time.
	 *
	 * @return string
	 */
	public function getHasTimeAttribute()
	{
	    return $this->cooking_time_hour || $this->cooking_time_minute || $this->preparation_time_hour || $this->preparation_time_minute;
	}

    /**
     * Scope a query to only include recipes to annotate.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToAnnotate($query)
    {
        return $query->where('annotated', '=', 0);
    }

    /**
     * Scope a query to only include recipes to annotate.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToValidate($query)
    {
        return $query->where('annotated', '>', 0);
    }
}
