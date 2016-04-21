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
    debug("postags");
    debug(count($postags));
    if (count($postags) < 1) {
        return $this->postag->all();

    } elseif (count($postags) == 1) {
        $first_postag = $this->getDatabaseRequestPostagsForWordId($word_id)->first();
        $complementary = $this->GetComplementaryPostags($first_postag)->random(1);
        $postags->push($complementary);
    }
    return $this->sortPostagsByName($postags)->values()->all();
}
private function GetComplementaryPostags($postag){
   $complementary_postags=Postag::select('postags.*')
   ->where('id','!=', $postag['id'])->get();
   return $complementary_postags;
}

public function getReferenceForWordId($word_id) {
  $postags = $this->getDatabaseRequestPostagsForWordId($word_id)->get();
  return $postags[0];
}

private function getDatabaseRequestPostagsForWordId($word_id) {
    $annotations = Annotation::join('postags', 'postags.id', '=', 'annotations.postag_id')
    ->select(DB::raw('postag_id as id, name, full_name, description'))
    ->distinct()
    ->where('word_id', $word_id)
    ->orderBy('confidence_score','desc');
    return $annotations;
}

private function sortPostagsByName($postags) {
    return $postags->sortBy(function($postags)
    {
      return $postags->name;
  });
}
}