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

	public function getById($id)
	{
		return $this->postag->findOrFail($id);
	}

	public function all()
	{
		return $this->postag->all();
	}

	public function count()
	{
		return $this->postag->count();
	}

	public function getPostagsForWordId($word_id) {
		$postags = $this->getDatabaseRequestPostagsForWordId($word_id)
                     	->get();
		debug($postags);
                /* pb ici quand les deux préannotations sont identiques, la liste entière est renvoyée */
		if (count($postags) > 1) {
			return $postags;
		} else {
			return $this->postag->all();
		}
	}

	public function getReferenceForWordId($word_id) {
		$postags = $this->getDatabaseRequestPostagsForWordId($word_id)
						->orderBy('annotation_count', 'desc')
                     	->get();
        return $postags[0];
	}

	private function getDatabaseRequestPostagsForWordId($word_id) {
		return Annotation::select(DB::raw('count(*) as annotation_count, postag_id as id, name'))
                     ->join('postags', 'postags.id', '=', 'annotations.postag_id')
                     ->where('word_id', $word_id)
                     ->groupBy('postag_id');
	}

}