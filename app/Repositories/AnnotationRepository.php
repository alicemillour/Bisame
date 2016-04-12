<?php

namespace App\Repositories;

use App\Models\Annotation;

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

}