<?php

namespace App\Repositories;

use App\Models\Postag;
use App\Models\Annotation;
use DB;


class PostagRepository extends ResourceRepository
{

    //protected $user;

    public function __construct(Postag $postag)
	{
		$this->postag = $postag;
	}

	public function all()
	{
		return $this->postag->all();
	}

	public function getPostagsForWordId($word_id) {
		$postags = Annotation::select(DB::raw('count(*) as annotation_count, postag_id as id, name'))
                     ->join('postags', 'postags.id', '=', 'annotations.postag_id')
                     ->where('word_id', $word_id)
                     ->groupBy('postag_id')
                     ->get();
		debug($postags);
		if (count($postags) > 1) {
			return $postags;
		} else {
			return $this->postag->all();
		}
	}

}