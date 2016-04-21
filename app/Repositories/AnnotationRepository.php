<?php

namespace App\Repositories;

use App\Models\Annotation;
use Illuminate\Support\Facades\DB;

class AnnotationRepository extends ResourceRepository
{


    public function __construct(Annotation $annotation)
	{
		$this->annotation = $annotation;
	}
    private function save(Annotation $annotation, Array $inputs)
	{
		$annotation->user_id = $inputs['user_id'];	
		$annotation->postag_id = $inputs['postag_id'];
		$annotation->word_id = $inputs['word_id'];	
		$annotation->save();
	}

	public function store(Array $inputs)
	{
		$annotation = new $this->annotation;		

		$this->save($annotation, $inputs);

		return $annotation;
	}

	public function getByWordId($word_id)
	{
		return $this->game->where('word_id', $word_id)->first();
	}
        
        public function getScore($user_id)
	{
            /* returns annotation count for user*/
            return $this->annotation->select(DB::raw('count(*) as annotation_count'))
                ->where('user_id', $user_id)->first();
        }  
        
        
}