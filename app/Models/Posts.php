<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = ['titre','contenu','user_id'];

	public $timestamps = true;

	public function user() 
	{
		return $this->belongsTo('App\Models\User');
	}
	public function tags()
	{
		return $this->belongsToMany('App\Tag');
	} 

}